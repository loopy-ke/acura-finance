<?php

namespace LoopyLabs\CreditFinancing;

use App\Facades\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use LoopyLabs\CreditFinancing\Services\CreditProcessorService;
use LoopyLabs\CreditFinancing\Services\CreditScoringService;
use LoopyLabs\CreditFinancing\Services\FinancingIntegrationService;
use LoopyLabs\CreditFinancing\Contracts\CreditProcessorInterface;
use LoopyLabs\CreditFinancing\Contracts\CreditScoringInterface;
use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditProduct;
use LoopyLabs\CreditFinancing\Policies\CreditApplicationPolicy;
use LoopyLabs\CreditFinancing\Policies\CreditProductPolicy;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionRegistrationService;
use App\Services\AppService;

class CreditFinancingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/credit-financing.php', 'credit-financing');

        $this->app->bind(CreditProcessorInterface::class, CreditProcessorService::class);
        $this->app->bind(CreditScoringInterface::class, CreditScoringService::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/credit-financing.php' => config_path('credit-financing.php'),
            ], 'credit-financing-config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'credit-financing-migrations');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if (file_exists(__DIR__ . '/../routes/api.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'credit-financing');

        $this->registerEventListeners();
        $this->registerPermissions();
        $this->registerPolicies();
        $this->registerSettings();
        $this->registerMenus();
        $this->registerAppDescription();
    }

    protected function registerEventListeners(): void
    {
        if (class_exists(\App\Events\Accounting\InvoiceCreated::class)) {
            Event::listen(\App\Events\Accounting\InvoiceCreated::class, function ($event) {
                if ($event->invoice->customer?->financing_enabled) {
                    \LoopyLabs\CreditFinancing\Jobs\ProcessCreditApplication::dispatch($event->invoice);
                }
            });
        }
    }

    protected function registerPermissions(): void
    {
        // Use the permission registration system
        $permissionService = app(PermissionRegistrationService::class);
        $permissionService->registerModulePermissions('credit_financing', [
            // Credit Applications
            [
                'name' => 'credit.applications.view',
                'display_name' => 'View Credit Applications',
                'description' => 'View credit application listings and details',
                'group' => 'credit_applications',
            ],
            [
                'name' => 'credit.applications.create',
                'display_name' => 'Create Credit Applications',
                'description' => 'Create new credit applications',
                'group' => 'credit_applications',
            ],
            [
                'name' => 'credit.applications.update',
                'display_name' => 'Update Credit Applications',
                'description' => 'Update credit application information',
                'group' => 'credit_applications',
            ],
            [
                'name' => 'credit.applications.delete',
                'display_name' => 'Delete Credit Applications',
                'description' => 'Delete credit applications',
                'group' => 'credit_applications',
            ],
            [
                'name' => 'credit.applications.approve',
                'display_name' => 'Approve Credit Applications',
                'description' => 'Approve or deny credit applications',
                'group' => 'credit_applications',
            ],

            // Credit Products
            [
                'name' => 'credit.products.view',
                'display_name' => 'View Credit Products',
                'description' => 'View credit product listings and details',
                'group' => 'credit_products',
            ],
            [
                'name' => 'credit.products.create',
                'display_name' => 'Create Credit Products',
                'description' => 'Create new credit products',
                'group' => 'credit_products',
            ],
            [
                'name' => 'credit.products.update',
                'display_name' => 'Update Credit Products',
                'description' => 'Update credit product information',
                'group' => 'credit_products',
            ],
            [
                'name' => 'credit.products.delete',
                'display_name' => 'Delete Credit Products',
                'description' => 'Delete credit products',
                'group' => 'credit_products',
            ],

            // Approval Workflow
            [
                'name' => 'credit.applications.approve.junior',
                'display_name' => 'Junior Level Approval',
                'description' => 'Approve credit applications at junior level',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.approve.senior',
                'display_name' => 'Senior Level Approval',
                'description' => 'Approve credit applications at senior level',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.approve.manager',
                'display_name' => 'Manager Level Approval',
                'description' => 'Approve credit applications at manager level',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.approve.director',
                'display_name' => 'Director Level Approval',
                'description' => 'Approve credit applications at director level',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.escalate',
                'display_name' => 'Escalate Applications',
                'description' => 'Escalate credit applications to higher levels',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.reassign',
                'display_name' => 'Reassign Applications',
                'description' => 'Reassign credit applications to other reviewers',
                'group' => 'credit_approvals',
            ],
            [
                'name' => 'credit.applications.bulk_assign',
                'display_name' => 'Bulk Assign Applications',
                'description' => 'Bulk assign credit applications',
                'group' => 'credit_approvals',
            ],

            // Reports
            [
                'name' => 'credit.reports.view',
                'display_name' => 'View Credit Reports',
                'description' => 'View credit reporting and analytics',
                'group' => 'credit_reports',
            ],

            // Interest Rate Management
            [
                'name' => 'credit.rates.view',
                'display_name' => 'View Interest Rates',
                'description' => 'View interest rate information',
                'group' => 'interest_rates',
            ],
            [
                'name' => 'credit.rates.request_change',
                'display_name' => 'Request Rate Changes',
                'description' => 'Request changes to interest rates',
                'group' => 'interest_rates',
            ],
            [
                'name' => 'credit.rates.approve_change',
                'display_name' => 'Approve Rate Changes',
                'description' => 'Approve interest rate change requests',
                'group' => 'interest_rates',
            ],
        ]);

        // Register credit-specific roles
        $permissionService->registerModuleRoles('credit_financing', [
            [
                'name' => 'credit_analyst',
                'display_name' => 'Credit Analyst',
                'description' => 'Can view and create credit applications',
                'permissions' => [
                    'credit.applications.view',
                    'credit.applications.create',
                    'credit.applications.update',
                    'credit.reports.view',
                ],
            ],
            [
                'name' => 'credit_officer',
                'display_name' => 'Credit Officer',
                'description' => 'Can manage credit applications and approve at junior level',
                'permissions' => [
                    'credit.applications.view',
                    'credit.applications.create',
                    'credit.applications.update',
                    'credit.applications.approve.junior',
                    'credit.applications.escalate',
                    'credit.reports.view',
                ],
            ],
            [
                'name' => 'senior_credit_officer',
                'display_name' => 'Senior Credit Officer',
                'description' => 'Can approve credit applications at senior level',
                'permissions' => [
                    'credit.applications.view',
                    'credit.applications.create',
                    'credit.applications.update',
                    'credit.applications.approve.junior',
                    'credit.applications.approve.senior',
                    'credit.applications.escalate',
                    'credit.applications.reassign',
                    'credit.reports.view',
                    'credit.rates.view',
                    'credit.rates.request_change',
                ],
            ],
            [
                'name' => 'credit_manager',
                'display_name' => 'Credit Manager',
                'description' => 'Can manage all credit operations',
                'permissions' => [
                    'credit.applications.view',
                    'credit.applications.create',
                    'credit.applications.update',
                    'credit.applications.delete',
                    'credit.applications.approve',
                    'credit.applications.approve.junior',
                    'credit.applications.approve.senior',
                    'credit.applications.approve.manager',
                    'credit.applications.escalate',
                    'credit.applications.reassign',
                    'credit.applications.bulk_assign',
                    'credit.products.view',
                    'credit.products.create',
                    'credit.products.update',
                    'credit.products.delete',
                    'credit.reports.view',
                    'credit.rates.view',
                    'credit.rates.request_change',
                    'credit.rates.approve_change',
                ],
            ],
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(CreditApplication::class, CreditApplicationPolicy::class);
        Gate::policy(CreditProduct::class, CreditProductPolicy::class);
    }

    protected function registerSettings(): void
    {
        if (function_exists('register_module_settings')) {
            try {
                register_module_settings('credit_financing', [
                    // Core Module Settings
                    'enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Credit Financing Module',
                        'description' => 'Enable or disable the credit financing module',
                        'section' => 'general',
                    ],

                    // Scoring Settings
                    'minimum_score' => [
                        'type' => 'integer',
                        'default' => 50,
                        'label' => 'Minimum Credit Score',
                        'description' => 'Minimum credit score required for application approval',
                        'section' => 'scoring',
                        'validation' => 'min:0|max:100',
                    ],

                    // Limit Settings
                    'min_application_amount' => [
                        'type' => 'decimal',
                        'default' => 10000,
                        'label' => 'Minimum Application Amount',
                        'description' => 'Minimum amount for credit applications',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0',
                    ],
                    'max_single_application' => [
                        'type' => 'decimal',
                        'default' => 1000000,
                        'label' => 'Maximum Single Application',
                        'description' => 'Maximum amount for a single credit application',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0',
                    ],
                    'max_total_credit' => [
                        'type' => 'decimal',
                        'default' => 5000000,
                        'label' => 'Maximum Total Credit',
                        'description' => 'Maximum total credit limit per customer',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0',
                    ],
                    'default_term_months' => [
                        'type' => 'integer',
                        'default' => 12,
                        'label' => 'Default Term (Months)',
                        'description' => 'Default repayment term in months',
                        'section' => 'limits',
                        'validation' => 'integer|min:1|max:120',
                    ],
                    'max_term_months' => [
                        'type' => 'integer',
                        'default' => 60,
                        'label' => 'Maximum Term (Months)',
                        'description' => 'Maximum repayment term in months',
                        'section' => 'limits',
                        'validation' => 'integer|min:1|max:120',
                    ],
                    'default_interest_rate' => [
                        'type' => 'decimal',
                        'default' => 0.12,
                        'label' => 'Default Interest Rate',
                        'description' => 'Default annual interest rate (as decimal, e.g., 0.12 for 12%)',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0|max:1',
                    ],
                    'default_fee_percentage' => [
                        'type' => 'decimal',
                        'default' => 0.03,
                        'label' => 'Default Fee Percentage',
                        'description' => 'Default fee percentage (as decimal, e.g., 0.03 for 3%)',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0|max:1',
                    ],

                    // Approval Settings
                    'auto_approve_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Auto Approval',
                        'description' => 'Allow automatic approval of qualifying applications',
                        'section' => 'approval',
                    ],
                    'auto_approve_limit' => [
                        'type' => 'decimal',
                        'default' => 100000,
                        'label' => 'Auto Approval Limit',
                        'description' => 'Maximum amount for automatic approval',
                        'section' => 'approval',
                        'validation' => 'numeric|min:0',
                    ],
                    'auto_approve_score' => [
                        'type' => 'integer',
                        'default' => 80,
                        'label' => 'Auto Approval Score',
                        'description' => 'Minimum credit score for automatic approval',
                        'section' => 'approval',
                        'validation' => 'integer|min:0|max:100',
                    ],
                    'manual_review_threshold' => [
                        'type' => 'decimal',
                        'default' => 250000,
                        'label' => 'Manual Review Threshold',
                        'description' => 'Amount above which manual review is required',
                        'section' => 'approval',
                        'validation' => 'numeric|min:0',
                    ],
                    'denial_score_threshold' => [
                        'type' => 'integer',
                        'default' => 50,
                        'label' => 'Denial Score Threshold',
                        'description' => 'Credit score below which applications are automatically denied',
                        'section' => 'approval',
                        'validation' => 'integer|min:0|max:100',
                    ],
                    'application_expiry_days' => [
                        'type' => 'integer',
                        'default' => 30,
                        'label' => 'Application Expiry Days',
                        'description' => 'Number of days after which applications expire',
                        'section' => 'approval',
                        'validation' => 'integer|min:1',
                    ],
                    'processing_sla_hours' => [
                        'type' => 'integer',
                        'default' => 48,
                        'label' => 'Processing SLA (Hours)',
                        'description' => 'Service level agreement for processing applications',
                        'section' => 'approval',
                        'validation' => 'integer|min:1',
                    ],

                    // Notification Settings
                    'notifications_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Notifications',
                        'description' => 'Enable system notifications for credit events',
                        'section' => 'notifications',
                    ],

                    // Reporting Settings
                    'report_cache_duration' => [
                        'type' => 'integer',
                        'default' => 60,
                        'label' => 'Report Cache Duration (Minutes)',
                        'description' => 'How long to cache report data',
                        'section' => 'reporting',
                        'validation' => 'integer|min:1',
                    ],
                    'data_retention_months' => [
                        'type' => 'integer',
                        'default' => 84,
                        'label' => 'Data Retention (Months)',
                        'description' => 'How long to retain credit data (7 years = 84 months)',
                        'section' => 'reporting',
                        'validation' => 'integer|min:1',
                    ],
                    'anonymize_after_months' => [
                        'type' => 'integer',
                        'default' => 60,
                        'label' => 'Anonymize After (Months)',
                        'description' => 'When to anonymize old data (5 years = 60 months)',
                        'section' => 'reporting',
                        'validation' => 'integer|min:1',
                    ],

                    // Business Rules
                    'max_applications_per_customer' => [
                        'type' => 'integer',
                        'default' => 3,
                        'label' => 'Max Applications Per Customer',
                        'description' => 'Maximum number of active applications per customer',
                        'section' => 'business_rules',
                        'validation' => 'integer|min:1',
                    ],
                    'min_relationship_months' => [
                        'type' => 'integer',
                        'default' => 6,
                        'label' => 'Minimum Relationship (Months)',
                        'description' => 'Minimum business relationship duration required',
                        'section' => 'business_rules',
                        'validation' => 'integer|min:0',
                    ],
                    'blacklist_check_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Blacklist Check',
                        'description' => 'Check customers against blacklists',
                        'section' => 'business_rules',
                    ],
                    'duplicate_check_days' => [
                        'type' => 'integer',
                        'default' => 30,
                        'label' => 'Duplicate Check Period (Days)',
                        'description' => 'Period to check for duplicate applications',
                        'section' => 'business_rules',
                        'validation' => 'integer|min:1',
                    ],
                    'cooling_off_period_days' => [
                        'type' => 'integer',
                        'default' => 90,
                        'label' => 'Cooling Off Period (Days)',
                        'description' => 'Waiting period after denied application',
                        'section' => 'business_rules',
                        'validation' => 'integer|min:0',
                    ],

                    // Automation Settings
                    'auto_scoring_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Auto Scoring',
                        'description' => 'Automatically score applications',
                        'section' => 'automation',
                    ],
                    'auto_decision_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Auto Decision',
                        'description' => 'Automatically make approval decisions',
                        'section' => 'automation',
                    ],
                    'auto_disbursement_enabled' => [
                        'type' => 'boolean',
                        'default' => false,
                        'label' => 'Enable Auto Disbursement',
                        'description' => 'Automatically disburse approved credits',
                        'section' => 'automation',
                    ],
                    'reminder_notifications' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Reminder Notifications',
                        'description' => 'Send automated reminder notifications',
                        'section' => 'automation',
                    ],
                    'escalation_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Escalation',
                        'description' => 'Escalate overdue applications',
                        'section' => 'automation',
                    ],
                    'escalation_hours' => [
                        'type' => 'integer',
                        'default' => 72,
                        'label' => 'Escalation Time (Hours)',
                        'description' => 'Hours before escalating pending applications',
                        'section' => 'automation',
                        'validation' => 'integer|min:1',
                    ],

                    // Security Settings
                    'encryption_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Encryption',
                        'description' => 'Encrypt sensitive credit data',
                        'section' => 'security',
                    ],
                    'audit_logging' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Audit Logging',
                        'description' => 'Log all credit-related activities',
                        'section' => 'security',
                    ],
                    'rate_limiting_enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Rate Limiting',
                        'description' => 'Limit API calls and applications per user',
                        'section' => 'security',
                    ],
                    'max_applications_per_day' => [
                        'type' => 'integer',
                        'default' => 10,
                        'label' => 'Max Applications Per Day',
                        'description' => 'Maximum applications per user per day',
                        'section' => 'security',
                        'validation' => 'integer|min:1',
                    ],
                    'max_api_calls_per_hour' => [
                        'type' => 'integer',
                        'default' => 100,
                        'label' => 'Max API Calls Per Hour',
                        'description' => 'Maximum API calls per user per hour',
                        'section' => 'security',
                        'validation' => 'integer|min:1',
                    ],

                    // Missing Rate Limits
                    'max_allowed_rate' => [
                        'type' => 'decimal',
                        'default' => 0.50,
                        'label' => 'Maximum Allowed Interest Rate',
                        'description' => 'Maximum interest rate that can be set (as decimal, e.g., 0.50 for 50%)',
                        'section' => 'limits',
                        'validation' => 'numeric|min:0|max:1',
                    ],

                    // API Integration Settings
                    'API_KEY' => [
                        'type' => 'string',
                        'default' => '',
                        'label' => 'API Key',
                        'description' => 'External service API key for credit checks',
                        'section' => 'integration',
                        'validation' => 'string|max:255',
                    ],
                    'API_ENDPOINT' => [
                        'type' => 'string',
                        'default' => '',
                        'label' => 'API Endpoint',
                        'description' => 'External service API endpoint URL',
                        'section' => 'integration',
                        'validation' => 'string|max:500',
                    ],

                    // Payment and Collection Settings
                    'max_missed_payments' => [
                        'type' => 'integer',
                        'default' => 2,
                        'label' => 'Max Missed Payments',
                        'description' => 'Maximum number of missed payments before escalation',
                        'section' => 'collections',
                        'validation' => 'integer|min:1|max:10',
                    ],
                    'legal_escalation_days' => [
                        'type' => 'integer',
                        'default' => 180,
                        'label' => 'Legal Escalation Days',
                        'description' => 'Number of days overdue before legal escalation',
                        'section' => 'collections',
                        'validation' => 'integer|min:30',
                    ],

                    // Accounting Integration
                    'accounting.enabled' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Enable Accounting Integration',
                        'description' => 'Enable integration with accounting module',
                        'section' => 'accounting',
                    ],
                    'auto_process_payments' => [
                        'type' => 'boolean',
                        'default' => true,
                        'label' => 'Auto Process Payments',
                        'description' => 'Automatically process payments when received',
                        'section' => 'accounting',
                    ],

                    // Additional Workflow Settings
                    'workflow_timeout_hours' => [
                        'type' => 'integer',
                        'default' => 168, // 7 days
                        'label' => 'Workflow Timeout (Hours)',
                        'description' => 'Number of hours before workflow times out',
                        'section' => 'approval',
                        'validation' => 'integer|min:1',
                    ],
                    'require_manager_approval_above' => [
                        'type' => 'decimal',
                        'default' => 500000,
                        'label' => 'Manager Approval Threshold',
                        'description' => 'Amount above which manager approval is required',
                        'section' => 'approval',
                        'validation' => 'numeric|min:0',
                    ],
                ]);
            } catch (\Exception $e) {
                // Skip if settings table doesn't exist yet
            }
        }
    }

    protected function registerMenus(): void
    {
        // Register the credit financing section
        Menu::registerSection('credit-financing', ['order' => 2.5]); // Between accounting (2) and system (3)
        
        // Register credit financing menu in its own section
        Menu::registerMenuCallback('credit-financing', function () {
            return [
                'title' => 'Credit Financing',
                'icon' => 'credit-card',
                'route_patterns' => ['credit.*'],
                'order' => 1,
                'children' => [
                    [
                        'title' => 'Applications',
                        'url' => route('credit.applications.index'),
                        'icon' => 'file-text',
                        'route_patterns' => ['credit.applications.*'],
                        'permission' => 'credit.applications.view',
                        'badge' => function () {
                            if (class_exists(\LoopyLabs\CreditFinancing\Models\CreditApplication::class)) {
                                try {
                                    return \LoopyLabs\CreditFinancing\Models\CreditApplication::where('status', 'under_review')->count() ?: null;
                                } catch (\Exception $e) {
                                    return null;
                                }
                            }
                            return null;
                        },
                    ],
                    [
                        'title' => 'Review Dashboard',
                        'url' => route('credit.review.dashboard'),
                        'icon' => 'clipboard-check',
                        'route_patterns' => ['credit.review.*'],
                        'permission' => 'credit.applications.approve',
                    ],
                    [
                        'title' => 'Disbursements',
                        'url' => route('credit.disbursements.index'),
                        'icon' => 'cash',
                        'route_patterns' => ['credit.disbursements.*'],
                        'permission' => 'credit.applications.view',
                    ],
                    [
                        'title' => 'Credit Products',
                        'url' => route('credit.products.index'),
                        'icon' => 'tag',
                        'route_patterns' => ['credit.products.*'],
                        'permission' => 'credit.products.view',
                    ],
                    [
                        'title' => 'Recovery & Collections',
                        'url' => route('credit.collection.index'),
                        'icon' => 'refresh',
                        'route_patterns' => ['credit.collection.*'],
                        'permission' => 'credit.applications.view',
                    ],
                    [
                        'title' => 'Credit Reports',
                        'url' => route('credit.reports.index'),
                        'icon' => 'chart-line',
                        'route_patterns' => ['credit.reports.*'],
                        'permission' => 'credit.reports.view',
                    ],
                ],
            ];
        }, 3); // Lower priority to ensure it runs after core menus
    }

    protected function registerAppDescription(): void
    {
        // Register this app's description contribution
        AppService::registerDescription('credit-financing', 'Credit & Financing');
    }
}
