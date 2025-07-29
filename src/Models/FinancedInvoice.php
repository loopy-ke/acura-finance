<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancedInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'credit_application_id',
        'financed_amount',
        'financing_fee',
        'interest_rate',
        'fee_percentage',
        'term_months',
        'status',
        'funded_date',
        'maturity_date',
        'collected_date',
        'total_collected',
        'partner_share',
        'our_share',
        'external_financing_id',
        'external_status',
        'funding_journal_entry_id',
        'collection_journal_entry_id',
    ];

    protected $casts = [
        'financed_amount' => 'decimal:2',
        'financing_fee' => 'decimal:2',
        'interest_rate' => 'decimal:4',
        'fee_percentage' => 'decimal:4',
        'total_collected' => 'decimal:2',
        'partner_share' => 'decimal:2',
        'our_share' => 'decimal:2',
        'funded_date' => 'date',
        'maturity_date' => 'date',
        'collected_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->maturity_date) && $model->funded_date && $model->term_months) {
                $model->maturity_date = $model->funded_date->copy()->addMonths($model->term_months);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('funded_date', 'term_months') && $model->funded_date && $model->term_months) {
                $model->maturity_date = $model->funded_date->copy()->addMonths($model->term_months);
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }

    public function creditApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class);
    }

    public function financingPartner(): BelongsTo
    {
        return $this->belongsTo(FinancingPartner::class);
    }

    public function fundingJournalEntry(): BelongsTo
    {
        return $this->belongsTo(\App\Models\JournalEntry::class, 'funding_journal_entry_id');
    }

    public function collectionJournalEntry(): BelongsTo
    {
        return $this->belongsTo(\App\Models\JournalEntry::class, 'collection_journal_entry_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'funded']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('maturity_date', '<', now())
            ->whereIn('status', ['active', 'funded']);
    }

    public function scopeCollected($query)
    {
        return $query->where('status', 'collected');
    }

    public function scopeDefaulted($query)
    {
        return $query->where('status', 'defaulted');
    }

    public function getNetAmountAttribute(): float
    {
        return $this->financed_amount - $this->financing_fee;
    }

    public function getRemainingBalanceAttribute(): float
    {
        return max(0, $this->financed_amount - $this->total_collected);
    }

    public function getCollectionPercentageAttribute(): float
    {
        if (!$this->financed_amount) {
            return 0;
        }
        
        return ($this->total_collected / $this->financed_amount) * 100;
    }

    public function getDaysToMaturityAttribute(): ?int
    {
        if (!$this->maturity_date) {
            return null;
        }
        
        return now()->diffInDays($this->maturity_date, false);
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->maturity_date || $this->maturity_date->isFuture()) {
            return 0;
        }
        
        return $this->maturity_date->diffInDays(now());
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'funded']);
    }

    public function isOverdue(): bool
    {
        return $this->maturity_date && $this->maturity_date->isPast() && $this->isActive();
    }

    public function isFullyCollected(): bool
    {
        return $this->status === 'collected' || 
            ($this->total_collected >= $this->financed_amount);
    }

    public function canBeCollected(): bool
    {
        return $this->isActive() && $this->remaining_balance > 0;
    }

    public function calculateInterestAccrued(): float
    {
        if (!$this->funded_date || !$this->interest_rate) {
            return 0;
        }
        
        $daysSinceFunding = $this->funded_date->diffInDays(now());
        $dailyRate = $this->interest_rate / 365;
        
        return $this->financed_amount * $dailyRate * $daysSinceFunding;
    }

    public function markAsCollected(float $amount): void
    {
        $this->total_collected += $amount;
        
        if ($this->total_collected >= $this->financed_amount) {
            $this->status = 'collected';
            $this->collected_date = now();
        }
        
        $this->save();
    }

    public function markAsDefaulted(): void
    {
        $this->status = 'defaulted';
        $this->save();
    }
}