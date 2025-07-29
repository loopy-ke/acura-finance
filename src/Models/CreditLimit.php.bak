<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class CreditLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'credit_limit',
        'used_credit',
        'default_interest_rate',
        'default_fee_percentage',
        'default_term_months',
        'status',
        'effective_date',
        'expiry_date',
        'last_reviewed_at',
        'next_review_date',
        'reviewed_by',
        'risk_rating',
        'auto_approve_limit',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'used_credit' => 'decimal:2',
        'default_interest_rate' => 'decimal:4',
        'default_fee_percentage' => 'decimal:4',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'last_reviewed_at' => 'datetime',
        'next_review_date' => 'date',
        'auto_approve_limit' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->effective_date)) {
                $model->effective_date = now()->toDateString();
            }
            if (empty($model->next_review_date)) {
                $model->next_review_date = now()->addYear()->toDateString();
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }


    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('effective_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<=', now());
    }

    public function scopeDueForReview($query)
    {
        return $query->where('next_review_date', '<=', now())
            ->where('status', 'active');
    }

    public function getAvailableCreditAttribute(): float
    {
        return max(0, $this->credit_limit - $this->used_credit);
    }

    public function getUtilizationPercentageAttribute(): float
    {
        if (!$this->credit_limit) {
            return 0;
        }
        
        return ($this->used_credit / $this->credit_limit) * 100;
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
            $this->effective_date <= now() &&
            (!$this->expiry_date || $this->expiry_date > now());
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date <= now();
    }

    public function isDueForReview(): bool
    {
        return $this->next_review_date && $this->next_review_date <= now();
    }

    public function hasAvailableCredit(float $amount): bool
    {
        return $this->isActive() && $this->available_credit >= $amount;
    }

    public function canAutoApprove(float $amount): bool
    {
        return $this->isActive() && 
            $amount <= $this->auto_approve_limit && 
            $this->hasAvailableCredit($amount);
    }

    public function increaseUsedCredit(float $amount): void
    {
        $this->used_credit += $amount;
        $this->save();
        
        // Update customer credit utilization
        if ($this->customer) {
            $this->customer->updateCreditUtilization();
        }
    }

    public function decreaseUsedCredit(float $amount): void
    {
        $this->used_credit = max(0, $this->used_credit - $amount);
        $this->save();
        
        // Update customer credit utilization
        if ($this->customer) {
            $this->customer->updateCreditUtilization();
        }
    }

    public function markAsReviewed(User $reviewer): void
    {
        $this->last_reviewed_at = now();
        $this->next_review_date = now()->addYear();
        $this->reviewed_by = $reviewer->id;
        $this->save();
    }

    public function suspend(string $reason = null): void
    {
        $this->status = 'suspended';
        $this->save();
        
        // Log the suspension reason if provided
        if ($reason) {
            activity()
                ->performedOn($this)
                ->withProperties(['reason' => $reason])
                ->log('Credit limit suspended');
        }
    }

    public function reactivate(): void
    {
        $this->status = 'active';
        $this->save();
        
        activity()
            ->performedOn($this)
            ->log('Credit limit reactivated');
    }

    public function calculateRecommendedLimit(): float
    {
        // Basic calculation based on customer payment history
        $customer = $this->customer;
        if (!$customer) {
            return 0;
        }
        
        // Get average monthly invoice amount over last 12 months
        $avgMonthlyInvoices = $customer->invoices()
            ->where('created_at', '>=', now()->subYear())
            ->avg('total_amount') ?? 0;
            
        // Conservative approach: 2x average monthly amount
        return $avgMonthlyInvoices * 2;
    }
}