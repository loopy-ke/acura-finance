# Credit & Financing Package API Documentation

## Overview
This document outlines the REST API endpoints for the Credit & Financing package. The API follows RESTful conventions and integrates seamlessly with the existing ERP system's authentication and authorization mechanisms.

## Base Configuration

**Base URL**: `/api/credit-financing`  
**Authentication**: Laravel Sanctum  
**Frontend**: TailwindCSS with Turbolinks for smooth navigation  
**Response Format**: JSON  
**API Version**: v1  

## Authentication

All endpoints require authentication via Laravel Sanctum tokens:

```http
Authorization: Bearer {your-api-token}
Content-Type: application/json
Accept: application/json
```

## Permission System

The package uses Laravel's Gate system with these permissions:

- `credit.view-applications` - View credit applications
- `credit.manage-applications` - Create and edit applications  
- `credit.approve-applications` - Approve/deny applications
- `credit.manage-partners` - Manage financing partners
- `credit.view-reports` - Access credit reports

## Error Handling

Standard HTTP status codes with JSON error responses:

```json
{
    "message": "Validation failed",
    "errors": {
        "requested_amount": ["The requested amount must be greater than 0"]
    },
    "status": 422
}
```

## Rate Limiting

- **General endpoints**: 60 requests per minute
- **Report endpoints**: 30 requests per minute
- **External partner sync**: 10 requests per minute

---

## Credit Applications API

### List Credit Applications

```http
GET /api/credit-financing/applications
```

**Parameters:**
- `page` (integer, optional) - Page number for pagination
- `per_page` (integer, optional) - Items per page (max 100)
- `status` (string, optional) - Filter by status
- `customer_id` (integer, optional) - Filter by customer
- `financing_partner_id` (integer, optional) - Filter by partner
- `date_from` (date, optional) - Filter by submission date from
- `date_to` (date, optional) - Filter by submission date to
- `sort` (string, optional) - Sort field (submission_date, requested_amount, status)
- `direction` (string, optional) - Sort direction (asc, desc)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "application_number": "CA-2024-001",
            "customer": {
                "id": 15,
                "customer_code": "CUST001",
                "company_name": "Acme Corp"
            },
            "financing_partner": {
                "id": 2,
                "partner_name": "FastCredit Solutions",
                "partner_type": "external"
            },
            "requested_amount": "25000.00",
            "approved_amount": "20000.00",
            "status": "approved",
            "submission_date": "2024-01-15T10:30:00Z",
            "decision_date": "2024-01-16T14:22:00Z",
            "created_at": "2024-01-15T10:30:00Z",
            "updated_at": "2024-01-16T14:22:00Z"
        }
    ],
    "links": {
        "first": "/api/credit-financing/applications?page=1",
        "last": "/api/credit-financing/applications?page=10",
        "prev": null,
        "next": "/api/credit-financing/applications?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "per_page": 15,
        "to": 15,
        "total": 142
    }
}
```

### Get Credit Application Details

```http
GET /api/credit-financing/applications/{id}
```

**Response:**
```json
{
    "data": {
        "id": 1,
        "application_number": "CA-2024-001",
        "customer": {
            "id": 15,
            "customer_code": "CUST001", 
            "company_name": "Acme Corp",
            "credit_limit": "50000.00",
            "credit_utilization": "40.00",
            "financing_enabled": true
        },
        "financing_partner": {
            "id": 2,
            "partner_name": "FastCredit Solutions",
            "partner_type": "external",
            "auto_approve_limit": "10000.00"
        },
        "invoice": {
            "id": 234,
            "invoice_number": "INV-2024-0156",
            "total_amount": "25000.00",
            "due_date": "2024-02-15"
        },
        "requested_amount": "25000.00",
        "requested_term_months": 12,
        "purpose": "Working capital for Q1 inventory purchase",
        "business_justification": "Seasonal inventory build-up for spring sales",
        "status": "approved",
        "submission_date": "2024-01-15T10:30:00Z",
        "decision_date": "2024-01-16T14:22:00Z",
        "approved_amount": "20000.00",
        "approved_term_months": 12,
        "approved_interest_rate": "0.0850",
        "approved_fee_percentage": "0.0300",
        "credit_score_at_application": 75,
        "automated_decision": "approve",
        "automated_decision_reason": "Customer meets all automated approval criteria",
        "decision": {
            "id": 12,
            "decision": "approved",
            "decision_maker": "automated",
            "credit_score": 75,
            "risk_rating": "medium",
            "scoring_factors": {
                "payment_history": 85,
                "credit_utilization": 70,
                "business_relationship": 80,
                "requested_amount_ratio": 65
            }
        },
        "created_by": {
            "id": 5,
            "name": "John Smith"
        },
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-16T14:22:00Z"
    }
}
```

### Create Credit Application

```http
POST /api/credit-financing/applications
```

**Request Body:**
```json
{
    "customer_id": 15,
    "financing_partner_id": 2,
    "invoice_id": 234,
    "requested_amount": "25000.00",
    "requested_term_months": 12,
    "purpose": "Working capital for Q1 inventory purchase",
    "business_justification": "Seasonal inventory build-up for spring sales"
}
```

**Validation Rules:**
- `customer_id` - required, exists in customers table
- `financing_partner_id` - optional, exists in financing_partners table
- `invoice_id` - optional, exists in invoices table
- `requested_amount` - required, numeric, min:100, max:1000000
- `requested_term_months` - optional, integer, min:1, max:60
- `purpose` - optional, string, max:500
- `business_justification` - optional, string, max:1000

**Response (201 Created):**
```json
{
    "data": {
        "id": 156,
        "application_number": "CA-2024-156",
        "status": "draft",
        "message": "Credit application created successfully. Submit when ready for processing."
    }
}
```

### Submit Credit Application

```http
POST /api/credit-financing/applications/{id}/submit
```

**Response (200 OK):**
```json
{
    "data": {
        "id": 156,
        "application_number": "CA-2024-156", 
        "status": "submitted",
        "submission_date": "2024-01-20T09:15:00Z",
        "estimated_decision_time": "24-48 hours",
        "message": "Application submitted successfully and is under review."
    }
}
```

### Approve Credit Application

```http
POST /api/credit-financing/applications/{id}/approve
```

**Requires Permission:** `credit.approve-applications`

**Request Body:**
```json
{
    "approved_amount": "20000.00",
    "approved_term_months": 12,
    "interest_rate": "0.0850",
    "fee_percentage": "0.0300",
    "conditions": "Standard terms and conditions apply",
    "notes": "Approved based on excellent payment history"
}
```

**Response (200 OK):**
```json
{
    "data": {
        "id": 156,
        "status": "approved",
        "decision_date": "2024-01-20T14:30:00Z",
        "approved_amount": "20000.00",
        "message": "Credit application approved successfully."
    }
}
```

### Deny Credit Application

```http
POST /api/credit-financing/applications/{id}/deny
```

**Requires Permission:** `credit.approve-applications`

**Request Body:**
```json
{
    "denial_reason_code": "INSUFFICIENT_CREDIT",
    "denial_reason_text": "Requested amount exceeds available credit limit",
    "notes": "Customer may reapply with lower amount"
}
```

**Response (200 OK):**
```json
{
    "data": {
        "id": 156,
        "status": "denied",
        "decision_date": "2024-01-20T14:30:00Z",
        "denial_reason": "Requested amount exceeds available credit limit",
        "message": "Credit application denied."
    }
}
```

---

## Financing Partners API

### List Financing Partners

```http
GET /api/credit-financing/partners
```

**Parameters:**
- `active_only` (boolean, optional) - Show only active partners
- `partner_type` (string, optional) - Filter by type (internal, external, bank, factoring)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "partner_code": "INTERNAL", 
            "partner_name": "Internal Financing",
            "partner_type": "internal",
            "is_active": true,
            "auto_approve_limit": "5000.00",
            "max_credit_limit": "100000.00",
            "default_interest_rate": "0.0750",
            "default_fee_percentage": "0.0250"
        },
        {
            "id": 2,
            "partner_code": "FASTCRED",
            "partner_name": "FastCredit Solutions", 
            "partner_type": "external",
            "is_active": true,
            "auto_approve_limit": "10000.00",
            "max_credit_limit": "500000.00",
            "default_interest_rate": "0.0850",
            "default_fee_percentage": "0.0300"
        }
    ]
}
```

### Get Financing Partner Details

```http
GET /api/credit-financing/partners/{id}
```

**Response:**
```json
{
    "data": {
        "id": 2,
        "partner_code": "FASTCRED",
        "partner_name": "FastCredit Solutions",
        "partner_type": "external",
        "contact_person": "Jane Doe",
        "email": "jane@fastcredit.com",
        "phone": "+1-555-0123",
        "is_active": true,
        "auto_approve_limit": "10000.00",
        "max_credit_limit": "500000.00",
        "default_interest_rate": "0.0850",
        "default_fee_percentage": "0.0300",
        "default_term_months": 12,
        "has_api_integration": true,
        "webhook_configured": true,
        "stats": {
            "total_applications": 45,
            "approved_applications": 38,
            "approval_rate": "84.44",
            "total_financed": "892300.00",
            "active_financings": 12
        }
    }
}
```

### Create Financing Partner

```http
POST /api/credit-financing/partners
```

**Requires Permission:** `credit.manage-partners`

**Request Body:**
```json
{
    "partner_code": "NEWPART",
    "partner_name": "New Partner Credit",
    "partner_type": "external",
    "contact_person": "Contact Name",
    "email": "contact@newpartner.com",
    "phone": "+1-555-0199",
    "auto_approve_limit": "7500.00",
    "max_credit_limit": "250000.00",
    "default_interest_rate": "0.0900",
    "default_fee_percentage": "0.0350",
    "cash_account_id": 1050,
    "fee_account_id": 5200,
    "ar_account_id": 1205
}
```

---

## Customer Credit API

### Get Customer Credit Profile

```http
GET /api/credit-financing/customers/{id}/credit-profile
```

**Response:**
```json
{
    "data": {
        "customer": {
            "id": 15,
            "customer_code": "CUST001",
            "company_name": "Acme Corp"
        },
        "credit_enabled": true,
        "current_credit_limit": "50000.00",
        "used_credit": "18000.00",
        "available_credit": "32000.00",
        "credit_utilization": "36.00",
        "credit_score": 78,
        "credit_score_updated_at": "2024-01-10T09:00:00Z",
        "risk_rating": "medium",
        "active_applications": 1,
        "active_financings": 3,
        "total_financed_ytd": "75000.00",
        "payment_history": {
            "total_invoices": 24,
            "paid_on_time": 22,
            "on_time_percentage": "91.67",
            "average_days_to_pay": 28.5
        },
        "recent_applications": [
            {
                "id": 156,
                "application_number": "CA-2024-156",
                "requested_amount": "25000.00",
                "status": "under_review",
                "submission_date": "2024-01-20T09:15:00Z"
            }
        ]
    }
}
```

### Update Customer Credit Limit

```http
PUT /api/credit-financing/customers/{id}/credit-limit
```

**Requires Permission:** `credit.approve-applications`

**Request Body:**
```json
{
    "credit_limit": "75000.00",
    "financing_partner_id": null,
    "risk_rating": "medium",
    "auto_approve_limit": "10000.00",
    "notes": "Increased limit based on improved payment history"
}
```

### Calculate Customer Credit Score

```http
POST /api/credit-financing/customers/{id}/calculate-score
```

**Response:**
```json
{
    "data": {
        "credit_score": 82,
        "previous_score": 78,
        "score_change": 4,
        "risk_rating": "medium",
        "scoring_breakdown": {
            "payment_history": {
                "score": 88,
                "weight": 0.35,
                "contribution": 30.8
            },
            "current_balance": {
                "score": 75,
                "weight": 0.20,
                "contribution": 15.0
            },
            "credit_utilization": {
                "score": 80,
                "weight": 0.15,
                "contribution": 12.0
            },
            "business_relationship": {
                "score": 85,
                "weight": 0.15,
                "contribution": 12.75
            },
            "financial_stability": {
                "score": 78,
                "weight": 0.15,
                "contribution": 11.7
            }
        },
        "calculated_at": "2024-01-20T15:45:00Z"
    }
}
```

---

## Financed Invoices API

### List Financed Invoices

```http
GET /api/credit-financing/financed-invoices
```

**Parameters:**
- `status` (string, optional) - Filter by status
- `financing_partner_id` (integer, optional) - Filter by partner
- `customer_id` (integer, optional) - Filter by customer
- `funded_from` (date, optional) - Filter by funded date from
- `funded_to` (date, optional) - Filter by funded date to

**Response:**
```json
{
    "data": [
        {
            "id": 45,
            "invoice": {
                "id": 234,
                "invoice_number": "INV-2024-0156",
                "total_amount": "25000.00",
                "due_date": "2024-02-15"
            },
            "customer": {
                "id": 15,
                "company_name": "Acme Corp"
            },
            "financing_partner": {
                "id": 2,
                "partner_name": "FastCredit Solutions"
            },
            "financed_amount": "20000.00",
            "financing_fee": "600.00",
            "net_amount": "19400.00",
            "interest_rate": "0.0850",
            "status": "active",
            "funded_date": "2024-01-21",
            "maturity_date": "2024-02-21",
            "days_to_maturity": 15
        }
    ]
}
```

### Get Financed Invoice Details

```http
GET /api/credit-financing/financed-invoices/{id}
```

**Response:**
```json
{
    "data": {
        "id": 45,
        "invoice": {
            "id": 234,
            "invoice_number": "INV-2024-0156",
            "customer_id": 15,
            "total_amount": "25000.00",
            "paid_amount": "0.00",
            "balance_due": "25000.00",
            "due_date": "2024-02-15",
            "status": "sent"
        },
        "credit_application": {
            "id": 156,
            "application_number": "CA-2024-156"
        },
        "financing_partner": {
            "id": 2,
            "partner_name": "FastCredit Solutions",
            "partner_type": "external"
        },
        "financed_amount": "20000.00",
        "financing_fee": "600.00",
        "net_amount": "19400.00",
        "interest_rate": "0.0850",
        "fee_percentage": "0.0300",
        "term_months": 12,
        "status": "active",
        "funded_date": "2024-01-21",
        "maturity_date": "2024-02-21",
        "total_collected": "0.00",
        "partner_share": "0.00",
        "our_share": "0.00",
        "external_financing_id": "FC-2024-789123",
        "journal_entries": [
            {
                "id": 1023,
                "type": "funding",
                "description": "Financing received for INV-2024-0156",
                "amount": "19400.00",
                "date": "2024-01-21"
            }
        ]
    }
}
```

---

## Reports API

### Credit Portfolio Dashboard

```http
GET /api/credit-financing/reports/portfolio-dashboard
```

**Requires Permission:** `credit.view-reports`

**Parameters:**
- `period` (string, optional) - Period filter (today, week, month, quarter, year)
- `partner_id` (integer, optional) - Filter by specific partner

**Response:**
```json
{
    "data": {
        "summary": {
            "total_applications": 156,
            "pending_applications": 12,
            "approved_applications": 128,
            "denied_applications": 16,
            "approval_rate": "82.05",
            "total_approved_amount": "2450000.00",
            "total_financed_amount": "2380000.00",
            "active_financings": 45,
            "total_outstanding": "892000.00"
        },
        "by_partner": [
            {
                "partner_name": "Internal Financing",
                "applications": 67,
                "approved": 62,
                "approval_rate": "92.54",
                "total_financed": "485000.00",
                "outstanding": "142000.00"
            },
            {
                "partner_name": "FastCredit Solutions", 
                "applications": 89,
                "approved": 66,
                "approval_rate": "74.16",
                "total_financed": "1895000.00",
                "outstanding": "750000.00"
            }
        ],
        "monthly_trend": [
            {
                "month": "2024-01",
                "applications": 23,
                "approved": 19,
                "total_amount": "485000.00"
            }
        ]
    }
}
```

### Credit Application Analytics

```http
GET /api/credit-financing/reports/application-analytics
```

**Parameters:**
- `date_from` (date, optional) - Start date for analysis
- `date_to` (date, optional) - End date for analysis

**Response:**
```json
{
    "data": {
        "application_volume": {
            "total": 156,
            "avg_per_day": 5.2,
            "peak_day": "2024-01-15",
            "peak_day_count": 12
        },
        "approval_metrics": {
            "overall_approval_rate": "82.05",
            "automated_approval_rate": "67.31",
            "manual_approval_rate": "14.74",
            "avg_processing_time_hours": 18.5
        },
        "amount_analysis": {
            "avg_requested": "18750.00",
            "avg_approved": "15680.00",
            "approval_to_request_ratio": "83.64",
            "largest_approved": "100000.00",
            "smallest_approved": "2500.00"
        },
        "denial_reasons": [
            {
                "reason": "Insufficient credit limit",
                "count": 8,
                "percentage": "50.00"
            },
            {
                "reason": "Poor payment history",
                "count": 5,
                "percentage": "31.25"
            }
        ]
    }
}
```

---

## Frontend Integration (TailwindCSS + Turbolinks)

### CSS Classes for Credit UI Components

**Application Status Badges:**
```html
<!-- Approved -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    Approved
</span>

<!-- Under Review -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
    Under Review
</span>

<!-- Denied -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
    Denied
</span>
```

**Credit Utilization Progress Bars:**
```html
<div class="w-full bg-gray-200 rounded-full h-2.5">
    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 36%"></div>
</div>
```

### Turbolinks Integration

**Form Submissions:**
```javascript
// Credit application form with Turbolinks
document.addEventListener('turbolinks:load', function() {
    const form = document.getElementById('credit-application-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';
        });
    }
});
```

**Real-time Status Updates:**
```javascript
// WebSocket integration for status updates
document.addEventListener('turbolinks:load', function() {
    if (window.Echo) {
        window.Echo.channel('credit-applications')
            .listen('CreditApplicationUpdated', (e) => {
                // Update status without page refresh
                Turbolinks.visit(window.location.href);
            });
    }
});
```

## WebSocket Events (Optional)

### Real-time Notifications

```javascript
// Listen for credit decision notifications
Echo.private(`user.${userId}`)
    .notification((notification) => {
        if (notification.type === 'CreditDecisionNotification') {
            showToast(notification.message, notification.type);
            updateApplicationStatus(notification.application_id, notification.status);
        }
    });
```

## Export Endpoints

### Export Applications to CSV

```http
GET /api/credit-financing/applications/export
```

**Parameters:**
- `format` (string) - Export format (csv, xlsx, pdf)
- Same filters as list endpoint

**Response:**
- File download with appropriate content-type
- Filename: `credit-applications-{date}.{format}`

This API documentation provides a complete reference for integrating the Credit & Financing package with your ERP system's frontend using TailwindCSS and Turbolinks for smooth, responsive user interactions.