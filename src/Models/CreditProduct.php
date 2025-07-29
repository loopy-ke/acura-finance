<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'min_amount',
        'max_amount',
        'min_term_months',
        'max_term_months',
        'interest_rate',
        'processing_fee_percentage',
        'early_payment_discount',
        'min_credit_score',
        'max_credit_score',
        'collateral_required',
        'guarantor_required',
        'is_active',
        'sort_order',
        'eligibility_criteria',
        'features',
        'metadata',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'interest_rate' => 'decimal:4',
        'processing_fee_percentage' => 'decimal:4',
        'early_payment_discount' => 'decimal:4',
        'collateral_required' => 'boolean',
        'guarantor_required' => 'boolean',
        'is_active' => 'boolean',
        'eligibility_criteria' => 'array',
        'features' => 'array',
        'metadata' => 'array',
    ];

    // Product categories
    const CATEGORY_SHORT_TERM = 'Short Term';
    const CATEGORY_MID_TERM = 'Mid Term';
    const CATEGORY_LONG_TERM = 'Long Term';

    const CATEGORIES = [
        self::CATEGORY_SHORT_TERM => 'Short Term (1-6 months)',
        self::CATEGORY_MID_TERM => 'Mid Term (6-24 months)',
        self::CATEGORY_LONG_TERM => 'Long Term (24+ months)',
    ];

    // Relationships
    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class);
    }

    // Alias for creditApplications (for compatibility)
    public function applications(): HasMany
    {
        return $this->creditApplications();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForAmount($query, float $amount)
    {
        return $query->where('min_amount', '<=', $amount)
                    ->where('max_amount', '>=', $amount);
    }

    public function scopeForTerm($query, int $termMonths)
    {
        return $query->where('min_term_months', '<=', $termMonths)
                    ->where('max_term_months', '>=', $termMonths);
    }

    public function scopeForCreditScore($query, int $creditScore)
    {
        return $query->where(function($q) use ($creditScore) {
            $q->whereNull('min_credit_score')
              ->orWhere('min_credit_score', '<=', $creditScore);
        })->where(function($q) use ($creditScore) {
            $q->whereNull('max_credit_score')
              ->orWhere('max_credit_score', '>=', $creditScore);
        });
    }

    // Helper Methods
    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function isEligibleForAmount(float $amount): bool
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }

    public function isEligibleForTerm(int $termMonths): bool
    {
        return $termMonths >= $this->min_term_months && $termMonths <= $this->max_term_months;
    }

    public function isEligibleForCreditScore(?int $creditScore): bool
    {
        if (!$creditScore) {
            return !$this->min_credit_score;
        }

        $minOk = !$this->min_credit_score || $creditScore >= $this->min_credit_score;
        $maxOk = !$this->max_credit_score || $creditScore <= $this->max_credit_score;

        return $minOk && $maxOk;
    }

    public function calculateProcessingFee(float $amount): float
    {
        return $amount * ($this->processing_fee_percentage / 100);
    }

    public function calculateMonthlyPayment(float $amount, int $termMonths): float
    {
        if ($termMonths <= 0) {
            return $amount;
        }

        // Simple calculation - could be enhanced with compound interest
        $monthlyInterest = $this->interest_rate / 12 / 100;
        $totalWithInterest = $amount * (1 + ($this->interest_rate / 100 * $termMonths / 12));
        
        return $totalWithInterest / $termMonths;
    }

    public function getInterestRatePercentageAttribute(): float
    {
        return $this->interest_rate * 100;
    }

    public function getProcessingFeePercentageDisplayAttribute(): float
    {
        return $this->processing_fee_percentage * 100;
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    public function meetsEligibilityCriteria(array $customerData): bool
    {
        if (!$this->eligibility_criteria) {
            return true;
        }

        foreach ($this->eligibility_criteria as $criterion => $requirement) {
            if (!$this->checkCriterion($criterion, $requirement, $customerData)) {
                return false;
            }
        }

        return true;
    }

    protected function checkCriterion(string $criterion, $requirement, array $customerData): bool
    {
        switch ($criterion) {
            case 'min_relationship_months':
                return ($customerData['relationship_months'] ?? 0) >= $requirement;
            
            case 'min_annual_revenue':
                return ($customerData['annual_revenue'] ?? 0) >= $requirement;
            
            case 'required_industry':
                return in_array($customerData['industry'] ?? '', (array) $requirement);
            
            case 'max_existing_applications':
                return ($customerData['active_applications'] ?? 0) <= $requirement;
            
            default:
                return true;
        }
    }

    // Static methods
    public static function getAvailableForCustomer($customer): \Illuminate\Database\Eloquent\Collection
    {
        $creditScore = $customer->creditCustomer?->credit_score;
        
        return static::active()
            ->forCreditScore($creditScore ?: 0)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->filter(function ($product) use ($customer) {
                return $product->meetsEligibilityCriteria([
                    'relationship_months' => $customer->getRelationshipDurationMonths(),
                    'industry' => $customer->metadata['industry'] ?? null,
                    'active_applications' => $customer->creditApplications()->whereIn('status', ['draft', 'submitted', 'under_review'])->count(),
                ]);
            });
    }
}