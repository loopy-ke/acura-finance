<?php

namespace CreditFinancing\Services;

use App\Services\Settings\BaseSettingsProvider;

class CreditFinancingSettingsProvider extends BaseSettingsProvider
{
    public function getSectionKey(): string
    {
        return 'credit_financing';
    }

    public function getOrder(): int
    {
        return 600; // After core settings
    }

    protected function getModule(): string
    {
        return 'credit_financing';
    }

    public function getSettingsSection(): array
    {
        return [
            'title' => 'Credit & Financing',
            'icon' => 'credit-card',
            'description' => 'Credit application and financing settings',
            'fields' => [
                [
                    'key' => 'default_credit_limit',
                    'type' => 'number',
                    'label' => 'Default Credit Limit',
                    'value' => $this->getSetting('default_credit_limit', 5000),
                    'step' => 0.01,
                    'min' => 0,
                    'help' => 'Default credit limit for new applications'
                ],
                [
                    'key' => 'auto_approve_limit',
                    'type' => 'number',
                    'label' => 'Auto-approve Below Amount',
                    'value' => $this->getSetting('auto_approve_limit', 1000),
                    'step' => 0.01,
                    'min' => 0,
                    'help' => 'Automatically approve credit applications below this amount'
                ],
                [
                    'key' => 'credit_score_requirement',
                    'type' => 'number',
                    'label' => 'Minimum Credit Score',
                    'value' => $this->getSetting('credit_score_requirement', 650),
                    'min' => 300,
                    'max' => 850,
                    'help' => 'Minimum credit score required for approval'
                ],
                [
                    'key' => 'require_manager_approval',
                    'type' => 'checkbox',
                    'label' => 'Require Manager Approval',
                    'value' => $this->getSetting('require_manager_approval', true),
                    'help' => 'Require manager approval for all credit applications'
                ],
                [
                    'key' => 'approval_timeout_hours',
                    'type' => 'number',
                    'label' => 'Approval Timeout (hours)',
                    'value' => $this->getSetting('approval_timeout_hours', 48),
                    'min' => 1,
                    'max' => 168,
                    'help' => 'Hours before approval request times out'
                ],
                [
                    'key' => 'enable_automated_scoring',
                    'type' => 'checkbox',
                    'label' => 'Enable Automated Credit Scoring',
                    'value' => $this->getSetting('enable_automated_scoring', true),
                    'help' => 'Use automated credit scoring algorithms'
                ],
                [
                    'key' => 'interest_rate',
                    'type' => 'number',
                    'label' => 'Default Interest Rate (%)',
                    'value' => $this->getSetting('interest_rate', 8.5),
                    'step' => 0.01,
                    'min' => 0,
                    'max' => 50,
                    'help' => 'Default annual interest rate for credit applications'
                ],
                [
                    'key' => 'collection_threshold_days',
                    'type' => 'number',
                    'label' => 'Collection Threshold (days)',
                    'value' => $this->getSetting('collection_threshold_days', 90),
                    'min' => 1,
                    'max' => 365,
                    'help' => 'Days overdue before starting collection process'
                ],
                [
                    'key' => 'enable_invoice_financing',
                    'type' => 'checkbox',
                    'label' => 'Enable Invoice Financing',
                    'value' => $this->getSetting('enable_invoice_financing', false),
                    'help' => 'Allow customers to finance specific invoices'
                ],
                [
                    'key' => 'max_financing_percentage',
                    'type' => 'number',
                    'label' => 'Max Financing Percentage (%)',
                    'value' => $this->getSetting('max_financing_percentage', 80),
                    'min' => 1,
                    'max' => 100,
                    'help' => 'Maximum percentage of invoice amount that can be financed'
                ],
                [
                    'key' => 'notification_email',
                    'type' => 'email',
                    'label' => 'Credit Team Email',
                    'value' => $this->getSetting('notification_email', ''),
                    'help' => 'Email address for credit application notifications'
                ],
                [
                    'key' => 'risk_assessment_model',
                    'type' => 'select',
                    'label' => 'Risk Assessment Model',
                    'value' => $this->getSetting('risk_assessment_model', 'standard'),
                    'options' => [
                        'basic' => 'Basic Model',
                        'standard' => 'Standard Model',
                        'advanced' => 'Advanced Model',
                        'custom' => 'Custom Model',
                    ],
                    'help' => 'Credit risk assessment model to use'
                ],
            ]
        ];
    }

    public function validateSettings(array $data): array
    {
        $errors = [];

        if (isset($data['default_credit_limit']) && $data['default_credit_limit'] < 0) {
            $errors['default_credit_limit'] = 'Credit limit must be positive';
        }

        if (isset($data['auto_approve_limit']) && $data['auto_approve_limit'] < 0) {
            $errors['auto_approve_limit'] = 'Auto-approve limit must be positive';
        }

        if (isset($data['credit_score_requirement'])) {
            $score = $data['credit_score_requirement'];
            if ($score < 300 || $score > 850) {
                $errors['credit_score_requirement'] = 'Credit score must be between 300 and 850';
            }
        }

        if (isset($data['approval_timeout_hours'])) {
            $hours = $data['approval_timeout_hours'];
            if ($hours < 1 || $hours > 168) {
                $errors['approval_timeout_hours'] = 'Approval timeout must be between 1 and 168 hours';
            }
        }

        if (isset($data['interest_rate'])) {
            $rate = $data['interest_rate'];
            if ($rate < 0 || $rate > 50) {
                $errors['interest_rate'] = 'Interest rate must be between 0 and 50 percent';
            }
        }

        if (isset($data['collection_threshold_days'])) {
            $days = $data['collection_threshold_days'];
            if ($days < 1 || $days > 365) {
                $errors['collection_threshold_days'] = 'Collection threshold must be between 1 and 365 days';
            }
        }

        if (isset($data['max_financing_percentage'])) {
            $percentage = $data['max_financing_percentage'];
            if ($percentage < 1 || $percentage > 100) {
                $errors['max_financing_percentage'] = 'Financing percentage must be between 1 and 100 percent';
            }
        }

        if (!empty($data['notification_email']) && !filter_var($data['notification_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['notification_email'] = 'Invalid email address';
        }

        return $errors;
    }
}