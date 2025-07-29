<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Credit Financing Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the credit financing module including limits,
    | scoring parameters, approval thresholds, and integration settings.
    |
    */

    'enabled' => setting('credit_financing.enabled', true),
    
    'scoring' => [
        'weights' => [
            'payment_history' => 0.35,
            'current_balance' => 0.25,
            'credit_utilization' => 0.20,
            'business_relationship' => 0.10,
            'financial_stability' => 0.10,
        ],
        'minimum_score' => setting('credit_financing.minimum_score', 50),
        'algorithm_version' => '1.0',
        'factors' => [
            'payment_history' => [
                'excellent_threshold' => 95, // % of on-time payments
                'good_threshold' => 85,
                'fair_threshold' => 70,
                'grace_period_days' => 7,
            ],
            'utilization' => [
                'optimal_min' => 10, // % utilization
                'optimal_max' => 30,
                'high_threshold' => 70,
                'over_limit_penalty' => 50,
            ],
            'relationship' => [
                'excellent_months' => 36,
                'good_months' => 24,
                'fair_months' => 12,
                'minimum_months' => 3,
            ],
            'stability' => [
                'trend_weight' => 0.6,
                'consistency_weight' => 0.4,
                'minimum_data_points' => 3,
            ],
        ],
    ],
    
    'limits' => [
        'min_application_amount' => setting('credit_financing.min_application_amount', 10000),
        'max_single_application' => setting('credit_financing.max_single_application', 1000000),
        'max_total_credit' => setting('credit_financing.max_total_credit', 5000000),
        'default_term_months' => setting('credit_financing.default_term_months', 12),
        'max_term_months' => setting('credit_financing.max_term_months', 60),
        'default_interest_rate' => setting('credit_financing.default_interest_rate', 0.12),
        'default_fee_percentage' => setting('credit_financing.default_fee_percentage', 0.03),
    ],
    
    'approval' => [
        'auto_approve_enabled' => setting('credit_financing.auto_approve_enabled', true),
        'auto_approve_limit' => setting('credit_financing.auto_approve_limit', 100000),
        'auto_approve_score' => setting('credit_financing.auto_approve_score', 80),
        'manual_review_threshold' => setting('credit_financing.manual_review_threshold', 250000),
        'denial_score_threshold' => setting('credit_financing.denial_score_threshold', 50),
        'application_expiry_days' => setting('credit_financing.application_expiry_days', 30),
        'processing_time_sla_hours' => setting('credit_financing.processing_sla_hours', 48),
    ],

    'risk_adjustments' => [
        'excellent' => [
            'score_min' => 90,
            'interest_multiplier' => 0.8,
            'fee_multiplier' => 0.8,
        ],
        'good' => [
            'score_min' => 80,
            'interest_multiplier' => 0.9,
            'fee_multiplier' => 0.9,
        ],
        'fair' => [
            'score_min' => 70,
            'interest_multiplier' => 1.0,
            'fee_multiplier' => 1.0,
        ],
        'poor' => [
            'score_min' => 60,
            'interest_multiplier' => 1.2,
            'fee_multiplier' => 1.1,
        ],
        'very_poor' => [
            'score_min' => 0,
            'interest_multiplier' => 1.5,
            'fee_multiplier' => 1.3,
        ],
    ],
    
    'partners' => [
        'internal' => [
            'enabled' => true,
            'name' => 'Internal Financing',
            'auto_approve_limit' => 100000.00,
            'default_interest_rate' => 0.12, // 12% annual
            'default_fee_percentage' => 0.03, // 3%
        ],
        'external_api' => [
            'enabled' => env('EXTERNAL_CREDIT_ENABLED', false),
            'api_key' => setting('credit_financing.API_KEY'),
            'endpoint' => setting('credit_financing.API_ENDPOINT'),
            'timeout' => 30,
            'retry_attempts' => 3,
        ],
    ],
    
    'accounting' => [
        'default_accounts' => [
            'ar_financed_code' => '1210', // Accounts Receivable - Financed
            'financing_fees_code' => '5250', // Financing Fees Income
            'partner_cash_code' => '1055', // Cash - Financing Partners
            'bad_debt_code' => '5300', // Bad Debt Expense
        ],
    ],
    
    'notifications' => [
        'enabled' => setting('credit_financing.notifications_enabled', true),
        'channels' => ['mail', 'database'],
        'events' => [
            'application_submitted' => [
                'enabled' => true,
                'channels' => ['database', 'mail'],
            ],
            'application_approved' => [
                'enabled' => true,
                'channels' => ['database', 'mail', 'sms'],
            ],
            'application_denied' => [
                'enabled' => true,
                'channels' => ['database', 'mail'],
            ],
            'financing_disbursed' => [
                'enabled' => true,
                'channels' => ['database', 'mail'],
            ],
            'payment_overdue' => [
                'enabled' => true,
                'channels' => ['database', 'mail', 'sms'],
            ],
            'limit_activated' => [
                'enabled' => true,
                'channels' => ['database', 'mail'],
            ],
            'limit_suspended' => [
                'enabled' => true,
                'channels' => ['database', 'mail'],
            ],
        ],
    ],
    
    'reporting' => [
        'cache_duration_minutes' => setting('credit_financing.report_cache_duration', 60),
        'default_period' => 'last_30_days',
        'export_formats' => ['csv', 'excel', 'pdf'],
        'retention_months' => setting('credit_financing.data_retention_months', 84), // 7 years
        'anonymize_after_months' => setting('credit_financing.anonymize_after_months', 60), // 5 years
    ],

    'business_rules' => [
        'max_applications_per_customer' => setting('credit_financing.max_applications_per_customer', 3),
        'min_relationship_months' => setting('credit_financing.min_relationship_months', 6),
        'blacklist_check_enabled' => setting('credit_financing.blacklist_check_enabled', true),
        'duplicate_application_check_days' => setting('credit_financing.duplicate_check_days', 30),
        'cooling_off_period_days' => setting('credit_financing.cooling_off_period_days', 90),
    ],

    'automation' => [
        'auto_scoring_enabled' => setting('credit_financing.auto_scoring_enabled', true),
        'auto_decision_enabled' => setting('credit_financing.auto_decision_enabled', true),
        'auto_disbursement_enabled' => setting('credit_financing.auto_disbursement_enabled', false),
        'reminder_notifications' => setting('credit_financing.reminder_notifications', true),
        'escalation_enabled' => setting('credit_financing.escalation_enabled', true),
        'escalation_hours' => setting('credit_financing.escalation_hours', 72),
    ],

    'security' => [
        'encryption_enabled' => setting('credit_financing.encryption_enabled', true),
        'audit_logging' => setting('credit_financing.audit_logging', true),
        'rate_limiting' => [
            'enabled' => setting('credit_financing.rate_limiting_enabled', true),
            'max_applications_per_day' => setting('credit_financing.max_applications_per_day', 10),
            'max_api_calls_per_hour' => setting('credit_financing.max_api_calls_per_hour', 100),
        ],
    ],
    
    'recovery' => [
        'grace_period_days' => 7,
        'reminder_intervals' => [7, 14, 21, 30], // Days after due date
        'escalation_levels' => [
            'level_1' => ['email'],
            'level_2' => ['email', 'sms'],
            'level_3' => ['email', 'sms', 'call'],
        ],
        'default_collection_fee_percentage' => 0.05, // 5%
    ],
];