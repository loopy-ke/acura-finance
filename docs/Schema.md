# Credit & Financing Package Database Schema

## Overview
This document outlines the database schema for the Credit & Financing package. The schema extends the core ERP accounting tables while maintaining referential integrity and supporting seamless integration.

## Schema Extension Strategy

The package follows a non-invasive extension approach:
- **Extends existing tables** with additional columns via migrations
- **Creates new tables** with foreign key relationships to core tables  
- **Maintains data integrity** through constraints and indexes
- **Supports rollback** without data loss

## Core Table Extensions

### 1. Customers Table Extension

Extends the existing `customers` table with credit-related fields:

```sql
-- Migration: add_credit_fields_to_customers.php
ALTER TABLE customers ADD COLUMN (
    credit_limit DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Current approved credit limit',
    financing_enabled BOOLEAN DEFAULT FALSE COMMENT 'Whether customer can use financing',
    credit_score INT NULL COMMENT 'Latest credit score (0-100)',
    credit_score_updated_at TIMESTAMP NULL COMMENT 'When credit score was last calculated',
    total_financed_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Total currently financed amount',
    credit_utilization DECIMAL(5,2) DEFAULT 0.00 COMMENT 'Credit utilization percentage',
    last_credit_check_at TIMESTAMP NULL COMMENT 'Last time credit was checked',
    
    INDEX idx_customers_credit_enabled (financing_enabled),
    INDEX idx_customers_credit_score (credit_score),
    INDEX idx_customers_credit_limit (credit_limit)
);
```

### 2. Invoices Table Extension

Extends the existing `invoices` table to track financing status:

```sql
-- Migration: add_financing_fields_to_invoices.php  
ALTER TABLE invoices ADD COLUMN (
    is_financed BOOLEAN DEFAULT FALSE COMMENT 'Whether this invoice is financed',
    financing_partner_id BIGINT NULL COMMENT 'Which partner financed this invoice',
    financed_amount DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Amount financed (may be partial)',
    financing_fee DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Fees charged for financing',
    financing_date DATE NULL COMMENT 'Date financing was approved',
    financing_status ENUM('pending', 'approved', 'funded', 'collected', 'defaulted') NULL,
    
    INDEX idx_invoices_financed (is_financed),
    INDEX idx_invoices_financing_partner (financing_partner_id),
    INDEX idx_invoices_financing_status (financing_status)
);
```

## New Package Tables

### 1. Financing Partners

Manages external and internal financing providers:

```sql
CREATE TABLE financing_partners (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    partner_code VARCHAR(20) UNIQUE NOT NULL COMMENT 'Short code for partner',
    partner_name VARCHAR(255) NOT NULL COMMENT 'Full partner name',
    partner_type ENUM('internal', 'external', 'bank', 'factoring') NOT NULL,
    
    -- Contact Information
    contact_person VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    address TEXT,
    
    -- API Integration
    api_endpoint VARCHAR(500) NULL COMMENT 'API URL for external partners',
    api_key VARCHAR(255) NULL COMMENT 'Encrypted API key',
    api_secret VARCHAR(255) NULL COMMENT 'Encrypted API secret',
    webhook_url VARCHAR(500) NULL COMMENT 'URL for status notifications',
    
    -- Configuration
    is_active BOOLEAN DEFAULT TRUE,
    auto_approve_limit DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Auto-approve up to this amount',
    max_credit_limit DECIMAL(15,2) DEFAULT 1000000.00 COMMENT 'Maximum credit this partner offers',
    default_interest_rate DECIMAL(5,4) DEFAULT 0.0000 COMMENT 'Default annual interest rate',
    default_fee_percentage DECIMAL(5,4) DEFAULT 0.0300 COMMENT 'Default fee percentage',
    default_term_months INT DEFAULT 12 COMMENT 'Default repayment term',
    
    -- Accounting Integration
    cash_account_id BIGINT NOT NULL COMMENT 'GL account for cash from this partner',
    fee_account_id BIGINT NOT NULL COMMENT 'GL account for fees to this partner',
    ar_account_id BIGINT NOT NULL COMMENT 'GL account for financed receivables',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (cash_account_id) REFERENCES accounts(id),
    FOREIGN KEY (fee_account_id) REFERENCES accounts(id),
    FOREIGN KEY (ar_account_id) REFERENCES accounts(id),
    
    INDEX idx_partner_code (partner_code),
    INDEX idx_partner_type (partner_type),
    INDEX idx_is_active (is_active)
);
```

### 2. Credit Applications

Tracks all credit applications and their lifecycle:

```sql
CREATE TABLE credit_applications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    application_number VARCHAR(50) UNIQUE NOT NULL COMMENT 'Human-readable application ID',
    
    -- Relationships
    customer_id BIGINT NOT NULL,
    financing_partner_id BIGINT NULL COMMENT 'Specific partner requested',
    invoice_id BIGINT NULL COMMENT 'Specific invoice to finance (optional)',
    created_by BIGINT NOT NULL COMMENT 'User who created application',
    
    -- Application Details
    requested_amount DECIMAL(15,2) NOT NULL COMMENT 'Amount requested',
    requested_term_months INT DEFAULT 12 COMMENT 'Requested repayment term',
    purpose TEXT COMMENT 'Purpose of credit request',
    business_justification TEXT COMMENT 'Why credit is needed',
    
    -- Processing Information
    status ENUM('draft', 'submitted', 'under_review', 'approved', 'denied', 'cancelled', 'expired') DEFAULT 'draft',
    submission_date TIMESTAMP NULL COMMENT 'When application was submitted',
    review_started_at TIMESTAMP NULL,
    decision_date TIMESTAMP NULL,
    
    -- Credit Assessment
    credit_score_at_application INT NULL COMMENT 'Credit score when applied',
    automated_decision ENUM('approve', 'deny', 'manual_review') NULL,
    automated_decision_reason TEXT NULL,
    
    -- External Partner Integration
    external_application_id VARCHAR(100) NULL COMMENT 'Partner\'s application ID',
    external_status VARCHAR(50) NULL COMMENT 'Status from external partner',
    external_response JSON NULL COMMENT 'Full response from external partner',
    
    -- Decision Information
    approved_amount DECIMAL(15,2) NULL COMMENT 'Amount approved (may differ from requested)',
    approved_term_months INT NULL,
    approved_interest_rate DECIMAL(5,4) NULL,
    approved_fee_percentage DECIMAL(5,4) NULL,
    
    -- Workflow
    requires_manual_approval BOOLEAN DEFAULT FALSE,
    approved_by BIGINT NULL COMMENT 'User who approved',
    denied_by BIGINT NULL COMMENT 'User who denied',
    denial_reason TEXT NULL,
    
    -- Audit
    expires_at TIMESTAMP NULL COMMENT 'When application expires if not acted upon',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (financing_partner_id) REFERENCES financing_partners(id),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (denied_by) REFERENCES users(id),
    
    INDEX idx_application_number (application_number),
    INDEX idx_customer (customer_id),
    INDEX idx_status (status),
    INDEX idx_submission_date (submission_date),
    INDEX idx_decision_date (decision_date),
    INDEX idx_financing_partner (financing_partner_id),
    INDEX idx_external_id (external_application_id)
);
```

### 3. Credit Decisions

Tracks detailed decision information and audit trail:

```sql
CREATE TABLE credit_decisions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    credit_application_id BIGINT NOT NULL,
    
    -- Decision Details
    decision ENUM('approved', 'denied', 'conditional', 'deferred') NOT NULL,
    decision_maker ENUM('automated', 'manual', 'external') NOT NULL,
    decision_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    decided_by BIGINT NULL COMMENT 'User ID if manual decision',
    
    -- Approved Terms (if approved)
    approved_amount DECIMAL(15,2) NULL,
    approved_term_months INT NULL,
    interest_rate DECIMAL(5,4) NULL,
    fee_percentage DECIMAL(5,4) NULL,
    conditions TEXT NULL COMMENT 'Any special conditions',
    
    -- Denial Information (if denied)
    denial_reason_code VARCHAR(20) NULL,
    denial_reason_text TEXT NULL,
    
    -- Scoring Information
    credit_score INT NULL,
    risk_rating ENUM('low', 'medium', 'high', 'very_high') NULL,
    scoring_factors JSON NULL COMMENT 'Detailed scoring breakdown',
    
    -- External Decision Data
    external_reference VARCHAR(100) NULL,
    external_decision_data JSON NULL,
    
    -- Documentation
    decision_document_path VARCHAR(500) NULL COMMENT 'Path to decision letter/agreement',
    terms_document_path VARCHAR(500) NULL COMMENT 'Path to terms and conditions',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (credit_application_id) REFERENCES credit_applications(id) ON DELETE CASCADE,
    FOREIGN KEY (decided_by) REFERENCES users(id),
    
    INDEX idx_application (credit_application_id),
    INDEX idx_decision (decision),
    INDEX idx_decision_date (decision_date),
    INDEX idx_decided_by (decided_by)
);
```

### 4. Financed Invoices

Tracks the relationship between invoices and financing:

```sql
CREATE TABLE financed_invoices (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    
    -- Relationships
    invoice_id BIGINT NOT NULL,
    credit_application_id BIGINT NOT NULL,
    financing_partner_id BIGINT NOT NULL,
    
    -- Financing Details
    financed_amount DECIMAL(15,2) NOT NULL COMMENT 'Amount financed (may be partial)',
    financing_fee DECIMAL(15,2) NOT NULL COMMENT 'Total fees charged',
    net_amount DECIMAL(15,2) GENERATED ALWAYS AS (financed_amount - financing_fee) STORED,
    
    -- Terms
    interest_rate DECIMAL(5,4) NOT NULL,
    fee_percentage DECIMAL(5,4) NOT NULL,
    term_months INT NOT NULL,
    
    -- Status Tracking
    status ENUM('pending', 'funded', 'active', 'collected', 'defaulted', 'charged_back') DEFAULT 'pending',
    funded_date DATE NULL COMMENT 'Date funds were received',
    maturity_date DATE NULL COMMENT 'When financing matures',
    collected_date DATE NULL COMMENT 'Date invoice was collected',
    
    -- Payment Tracking
    total_collected DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Total amount collected from customer',
    partner_share DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Amount paid to financing partner',
    our_share DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Amount retained by us',
    
    -- External Integration
    external_financing_id VARCHAR(100) NULL COMMENT 'Partner\'s financing reference',
    external_status VARCHAR(50) NULL,
    
    -- Journal Entry References
    funding_journal_entry_id BIGINT NULL COMMENT 'JE when funds received',
    collection_journal_entry_id BIGINT NULL COMMENT 'JE when invoice collected',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (credit_application_id) REFERENCES credit_applications(id),
    FOREIGN KEY (financing_partner_id) REFERENCES financing_partners(id),
    FOREIGN KEY (funding_journal_entry_id) REFERENCES journal_entries(id),
    FOREIGN KEY (collection_journal_entry_id) REFERENCES journal_entries(id),
    
    UNIQUE KEY unique_invoice_financing (invoice_id), -- One financing per invoice
    INDEX idx_status (status),
    INDEX idx_funded_date (funded_date),
    INDEX idx_maturity_date (maturity_date),
    INDEX idx_financing_partner (financing_partner_id),
    INDEX idx_external_id (external_financing_id)
);
```

### 5. Credit Limits

Manages customer credit limits and utilization:

```sql
CREATE TABLE credit_limits (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    customer_id BIGINT NOT NULL,
    financing_partner_id BIGINT NULL COMMENT 'Partner-specific limit, NULL for internal',
    
    -- Limit Information
    credit_limit DECIMAL(15,2) NOT NULL,
    available_credit DECIMAL(15,2) GENERATED ALWAYS AS (credit_limit - used_credit) STORED,
    used_credit DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Currently outstanding financed amount',
    
    -- Terms
    default_interest_rate DECIMAL(5,4) NULL,
    default_fee_percentage DECIMAL(5,4) NULL,
    default_term_months INT NULL,
    
    -- Status
    status ENUM('active', 'suspended', 'cancelled', 'expired') DEFAULT 'active',
    effective_date DATE NOT NULL,
    expiry_date DATE NULL,
    
    -- Review Information
    last_reviewed_at TIMESTAMP NULL,
    next_review_date DATE NULL,
    reviewed_by BIGINT NULL,
    
    -- Risk Management
    risk_rating ENUM('low', 'medium', 'high', 'very_high') DEFAULT 'medium',
    auto_approve_limit DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Auto-approve up to this amount',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (financing_partner_id) REFERENCES financing_partners(id),
    FOREIGN KEY (reviewed_by) REFERENCES users(id),
    
    UNIQUE KEY unique_customer_partner (customer_id, financing_partner_id),
    INDEX idx_customer (customer_id),
    INDEX idx_status (status),
    INDEX idx_expiry_date (expiry_date),
    INDEX idx_next_review (next_review_date)
);
```

### 6. Credit Scoring History

Maintains historical credit scoring data:

```sql
CREATE TABLE credit_scoring_history (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    customer_id BIGINT NOT NULL,
    credit_application_id BIGINT NULL COMMENT 'Application that triggered scoring',
    
    -- Score Information
    credit_score INT NOT NULL COMMENT 'Score 0-100',
    score_version VARCHAR(10) NOT NULL COMMENT 'Scoring algorithm version',
    
    -- Score Breakdown
    payment_history_score INT NOT NULL,
    current_balance_score INT NOT NULL,
    credit_utilization_score INT NOT NULL,
    business_relationship_score INT NOT NULL,
    financial_stability_score INT NOT NULL,
    
    -- Supporting Data
    total_invoices_count INT DEFAULT 0,
    paid_on_time_count INT DEFAULT 0,
    average_days_to_pay DECIMAL(5,2) DEFAULT 0.00,
    current_outstanding_balance DECIMAL(15,2) DEFAULT 0.00,
    longest_relationship_months INT DEFAULT 0,
    
    -- Metadata
    scoring_factors JSON NULL COMMENT 'Detailed factors used in scoring',
    external_data_sources JSON NULL COMMENT 'External credit data if used',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (credit_application_id) REFERENCES credit_applications(id),
    
    INDEX idx_customer (customer_id),
    INDEX idx_score (credit_score),
    INDEX idx_created_at (created_at),
    INDEX idx_application (credit_application_id)
);
```

## Reporting Views

### 1. Credit Portfolio Summary

```sql
CREATE VIEW credit_portfolio_summary AS
SELECT 
    fp.partner_name,
    COUNT(DISTINCT fi.customer_id) as active_customers,
    COUNT(fi.id) as total_financed_invoices,
    SUM(fi.financed_amount) as total_financed_amount,
    SUM(fi.financing_fee) as total_fees_earned,
    SUM(fi.total_collected) as total_collected,
    SUM(CASE WHEN fi.status = 'defaulted' THEN fi.financed_amount ELSE 0 END) as total_defaults,
    AVG(fi.term_months) as avg_term_months,
    AVG(fi.interest_rate) as avg_interest_rate
FROM financing_partners fp
LEFT JOIN financed_invoices fi ON fp.id = fi.financing_partner_id
WHERE fi.status IN ('active', 'collected', 'defaulted')
GROUP BY fp.id, fp.partner_name;
```

### 2. Customer Credit Utilization

```sql
CREATE VIEW customer_credit_utilization AS
SELECT 
    c.id as customer_id,
    c.customer_code,
    c.company_name,
    cl.credit_limit,
    cl.used_credit,
    cl.available_credit,
    c.credit_utilization,
    COUNT(fi.id) as active_financings,
    SUM(fi.financed_amount) as total_financed,
    cl.status as credit_status,
    cl.risk_rating
FROM customers c
LEFT JOIN credit_limits cl ON c.id = cl.customer_id
LEFT JOIN financed_invoices fi ON c.id = fi.customer_id AND fi.status = 'active'
WHERE c.financing_enabled = TRUE
GROUP BY c.id, cl.id;
```

### 3. Credit Application Pipeline

```sql
CREATE VIEW credit_application_pipeline AS
SELECT 
    ca.status,
    COUNT(*) as application_count,
    SUM(ca.requested_amount) as total_requested,
    AVG(ca.requested_amount) as avg_requested,
    AVG(CASE WHEN ca.approved_amount IS NOT NULL THEN ca.approved_amount ELSE 0 END) as avg_approved,
    COUNT(CASE WHEN ca.status = 'approved' THEN 1 END) as approved_count,
    COUNT(CASE WHEN ca.status = 'denied' THEN 1 END) as denied_count,
    ROUND(COUNT(CASE WHEN ca.status = 'approved' THEN 1 END) * 100.0 / COUNT(*), 2) as approval_rate
FROM credit_applications ca
WHERE ca.submission_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
GROUP BY ca.status;
```

## Data Integrity Constraints

### 1. Credit Limit Validation

```sql
-- Trigger to ensure used_credit doesn't exceed credit_limit
DELIMITER //
CREATE TRIGGER check_credit_limit_usage 
BEFORE UPDATE ON credit_limits
FOR EACH ROW
BEGIN
    IF NEW.used_credit > NEW.credit_limit THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Used credit cannot exceed credit limit';
    END IF;
END//
DELIMITER ;
```

### 2. Application Amount Validation

```sql
-- Check constraint to ensure approved amount doesn't exceed requested amount
ALTER TABLE credit_applications 
ADD CONSTRAINT chk_approved_amount 
CHECK (approved_amount IS NULL OR approved_amount <= requested_amount);
```

### 3. Financing Amount Validation

```sql
-- Check constraint to ensure financed amount doesn't exceed invoice total
ALTER TABLE financed_invoices
ADD CONSTRAINT chk_financed_amount_valid
CHECK (financed_amount <= (SELECT total_amount FROM invoices WHERE id = invoice_id));
```

## Indexes for Performance

### Primary Performance Indexes

```sql
-- Customer credit lookups
CREATE INDEX idx_customers_credit_composite ON customers (financing_enabled, credit_limit, credit_utilization);

-- Application processing
CREATE INDEX idx_applications_processing ON credit_applications (status, submission_date, financing_partner_id);

-- Invoice financing lookups  
CREATE INDEX idx_financed_invoices_active ON financed_invoices (status, maturity_date, financing_partner_id);

-- Credit scoring queries
CREATE INDEX idx_scoring_customer_date ON credit_scoring_history (customer_id, created_at DESC);

-- Reporting queries
CREATE INDEX idx_financed_reporting ON financed_invoices (status, funded_date, financing_partner_id, financed_amount);
```

## Data Archival Strategy

### 1. Application Archival

Applications older than 7 years moved to archive tables:

```sql
CREATE TABLE credit_applications_archive LIKE credit_applications;
CREATE TABLE credit_decisions_archive LIKE credit_decisions;
```

### 2. Scoring History Archival

Keep only latest score per customer in main table, move rest to archive:

```sql
CREATE TABLE credit_scoring_history_archive LIKE credit_scoring_history;
```

## Migration Scripts

### 1. Installation Migration Order

```php
// Migration order for installation
$migrations = [
    '2024_01_01_000001_add_credit_fields_to_customers.php',
    '2024_01_01_000002_add_financing_fields_to_invoices.php', 
    '2024_01_01_000003_create_financing_partners_table.php',
    '2024_01_01_000004_create_credit_applications_table.php',
    '2024_01_01_000005_create_credit_decisions_table.php',
    '2024_01_01_000006_create_financed_invoices_table.php',
    '2024_01_01_000007_create_credit_limits_table.php',
    '2024_01_01_000008_create_credit_scoring_history_table.php',
    '2024_01_01_000009_create_credit_views.php',
    '2024_01_01_000010_create_credit_indexes.php',
];
```

### 2. Rollback Strategy

Each migration includes proper rollback:

```php
public function down()
{
    // Drop foreign key constraints first
    Schema::table('financed_invoices', function (Blueprint $table) {
        $table->dropForeign(['invoice_id']);
        $table->dropForeign(['credit_application_id']);
    });
    
    // Drop tables in reverse order
    Schema::dropIfExists('financed_invoices');
    // ... continue for all tables
    
    // Remove added columns from existing tables
    Schema::table('customers', function (Blueprint $table) {
        $table->dropColumn([
            'credit_limit', 'financing_enabled', 'credit_score'
        ]);
    });
}
```

This schema design ensures seamless integration with the existing accounting system while providing robust credit and financing functionality with proper data integrity, performance optimization, and maintainability.