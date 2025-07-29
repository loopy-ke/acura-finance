<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\User;

class CreditRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'credit_disbursement_id',
        'customer_id',
        'payment_amount',
        'principal_amount',
        'interest_amount',
        'fee_amount',
        'penalty_amount',
        'currency',
        'payment_method',
        'status',
        'payment_reference',
        'transaction_id',
        'bank_reference',
        'mobile_reference',
        'payment_date',
        'processed_at',
        'value_date',
        'created_by',
        'processed_by',
        'payment_notes',
        'metadata',
    ];

    protected $casts = [
        'payment_amount' => 'decimal:2',
        'principal_amount' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'payment_date' => 'date',
        'processed_at' => 'datetime',
        'value_date' => 'date',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($repayment) {
            if (empty($repayment->payment_number)) {
                $repayment->payment_number = static::generatePaymentNumber();
            }
        });
    }

    // Relationships
    public function creditDisbursement(): BelongsTo
    {
        return $this->belongsTo(CreditDisbursement::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByPaymentMethod($query, string $method)
    {
        return $query->where('payment_method', $method);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->payment_amount, 2);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'reversed' => 'bg-orange-100 text-orange-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Business Logic Methods
    public function canBeProcessed(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending']);
    }

    public function canBeReversed(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted(User $processedBy): void
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now(),
            'processed_by' => $processedBy->id,
            'value_date' => $this->value_date ?: $this->payment_date,
        ]);
    }

    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'payment_notes' => $reason,
        ]);
    }

    public function reverse(User $reversedBy, string $reason): void
    {
        $this->update([
            'status' => 'reversed',
            'processed_by' => $reversedBy->id,
            'processed_at' => now(),
            'payment_notes' => $reason,
        ]);

        // Update disbursement balances
        $disbursement = $this->creditDisbursement;
        $disbursement->total_repaid -= $this->payment_amount;
        $disbursement->principal_repaid -= $this->principal_amount;
        $disbursement->interest_repaid -= $this->interest_amount;
        $disbursement->fees_repaid -= $this->fee_amount;
        $disbursement->updateBalances();
    }

    protected static function generatePaymentNumber(): string
    {
        $prefix = 'PAY';
        $year = date('Y');
        $month = date('m');
        
        $lastPayment = static::where('payment_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('payment_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->payment_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}