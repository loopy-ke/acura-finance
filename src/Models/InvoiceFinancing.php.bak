<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceFinancing extends Model
{
    use HasFactory;

    protected $table = 'invoice_financing';

    protected $fillable = [
        'credit_disbursement_id',
        'invoice_id',
        'invoice_amount',
        'financed_amount',
        'advance_rate',
        'discount_rate',
        'discount_amount',
        'invoice_date',
        'invoice_due_date',
        'financing_date',
        'collection_due_date',
        'status',
        'collected_amount',
        'collected_at',
        'days_to_collect',
    ];

    protected $casts = [
        'invoice_amount' => 'decimal:2',
        'financed_amount' => 'decimal:2',
        'advance_rate' => 'decimal:4',
        'discount_rate' => 'decimal:6',
        'discount_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'invoice_date' => 'date',
        'invoice_due_date' => 'date',
        'financing_date' => 'date',
        'collection_due_date' => 'date',
        'collected_at' => 'datetime',
    ];

    // Relationships
    public function creditDisbursement(): BelongsTo
    {
        return $this->belongsTo(CreditDisbursement::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }

    // Scopes
    public function scopeFinanced($query)
    {
        return $query->where('status', 'financed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                    ->orWhere(function($q) {
                        $q->where('status', 'financed')
                          ->where('collection_due_date', '<', now());
                    });
    }

    // Accessors
    public function getFormattedFinancedAmountAttribute(): string
    {
        return number_format($this->financed_amount, 2);
    }

    public function getCollectionPercentageAttribute(): float
    {
        if ($this->financed_amount <= 0) {
            return 0;
        }
        
        return ($this->collected_amount / $this->financed_amount) * 100;
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->collection_due_date && 
               $this->collection_due_date->isPast() && 
               $this->collected_amount < $this->financed_amount;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'financed' => 'bg-blue-100 text-blue-800',
            'collected' => 'bg-green-100 text-green-800',
            'overdue' => 'bg-red-100 text-red-800',
            'defaulted' => 'bg-red-100 text-red-800',
            'written_off' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Business Logic Methods
    public function markAsCollected(float $amount = null): void
    {
        $collectedAmount = $amount ?? $this->financed_amount;
        
        $this->update([
            'status' => 'collected',
            'collected_amount' => $collectedAmount,
            'collected_at' => now(),
            'days_to_collect' => $this->financing_date->diffInDays(now()),
        ]);
    }

    public function markAsOverdue(): void
    {
        if ($this->status === 'financed' && $this->is_overdue) {
            $this->update(['status' => 'overdue']);
        }
    }

    public function calculateFinancingCost(): float
    {
        return $this->invoice_amount * $this->discount_rate;
    }

    public function calculateNetAdvance(): float
    {
        return $this->financed_amount - $this->discount_amount;
    }
}