<?php

namespace LoopyLabs\CreditFinancing\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'financing_enabled',
        'credit_limit',
        'credit_score',
        'credit_score_updated_at',
        'total_financed_amount',
        'credit_utilization',
        'last_credit_check_at',
        'credit_references',
        'credit_metadata',
    ];

    protected $casts = [
        'financing_enabled' => 'boolean',
        'credit_limit' => 'decimal:2',
        'total_financed_amount' => 'decimal:2',
        'credit_utilization' => 'decimal:2',
        'credit_score_updated_at' => 'datetime',
        'last_credit_check_at' => 'datetime',
        'credit_references' => 'array',
        'credit_metadata' => 'array',
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creditApplications(): HasMany
    {
        return $this->hasMany(CreditApplication::class, 'customer_id', 'customer_id');
    }

    public function financedInvoices(): HasMany
    {
        return $this->hasMany(FinancedInvoice::class, 'customer_id', 'customer_id');
    }

    public function collectionCases(): HasMany
    {
        return $this->hasMany(CollectionCase::class, 'customer_id', 'customer_id');
    }


    // Scopes
    public function scopeFinancingEnabled($query)
    {
        return $query->where('financing_enabled', true);
    }

    public function scopeWithCreditScore($query)
    {
        return $query->whereNotNull('credit_score');
    }

    // Helper Methods
    public function canApplyForCredit(): bool
    {
        return $this->financing_enabled && 
               $this->customer->is_active &&
               $this->customer->status === 'active' &&
               $this->customer->relationship_start_date &&
               $this->customer->relationship_start_date->diffInMonths(now()) >= 6;
    }

    public function hasAvailableCredit(float $amount = 0): bool
    {
        $availableCredit = $this->credit_limit - $this->total_financed_amount;
        return $availableCredit >= $amount;
    }

    public function updateCreditUtilization(): void
    {
        if ($this->credit_limit > 0) {
            $utilization = ($this->total_financed_amount / $this->credit_limit) * 100;
            $this->update(['credit_utilization' => min(100, $utilization)]);
        }
    }

    public function getCreditScoreStatus(): string
    {
        if (!$this->credit_score) {
            return 'no_score';
        }

        return match (true) {
            $this->credit_score >= 80 => 'excellent',
            $this->credit_score >= 70 => 'good',
            $this->credit_score >= 60 => 'fair',
            $this->credit_score >= 50 => 'poor',
            default => 'very_poor'
        };
    }

    public function getCreditScoreGradeAttribute(): string
    {
        if (!$this->credit_score) {
            return 'N/A';
        }

        if ($this->credit_score >= 800) return 'A+';
        if ($this->credit_score >= 780) return 'A';
        if ($this->credit_score >= 740) return 'A-';
        if ($this->credit_score >= 720) return 'B+';
        if ($this->credit_score >= 680) return 'B';
        if ($this->credit_score >= 650) return 'B-';
        if ($this->credit_score >= 620) return 'C+';
        if ($this->credit_score >= 580) return 'C';
        if ($this->credit_score >= 550) return 'C-';
        
        return 'D';
    }

    public function getRiskLevelAttribute(): string
    {
        $grade = $this->credit_score_grade;
        
        if (in_array($grade, ['A+', 'A', 'A-'])) return 'Low';
        if (in_array($grade, ['B+', 'B', 'B-'])) return 'Medium';
        if (in_array($grade, ['C+', 'C', 'C-'])) return 'High';
        
        return 'Very High';
    }

    // Static methods for easier access
    public static function getOrCreateForCustomer(int $customerId): self
    {
        return static::firstOrCreate(
            ['customer_id' => $customerId],
            ['financing_enabled' => false, 'credit_limit' => 0]
        );
    }
}