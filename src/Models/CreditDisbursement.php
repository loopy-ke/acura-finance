<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class CreditDisbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'disbursement_number',
        'credit_application_id',
        'customer_id',
        'credit_limit_id',
        'disbursement_amount',
        'fee_amount',
        'net_amount',
        'currency',
        'term_months',
        'interest_rate',
        'fee_percentage',
        'due_date',
        'maturity_date',
        'status',
        'disbursement_method',
        'bank_name',
        'account_number',
        'account_name',
        'mobile_number',
        'payment_reference',
        'transaction_id',
        'total_repaid',
        'principal_repaid',
        'interest_repaid',
        'fees_repaid',
        'outstanding_balance',
        'total_interest',
        'total_amount_due',
        'disbursed_at',
        'first_payment_due',
        'last_payment_date',
        'days_overdue',
        'created_by',
        'approved_by',
        'disbursed_by',
        'disbursement_notes',
        'terms_and_conditions',
        'metadata',
    ];

    protected $casts = [
        'disbursement_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'interest_rate' => 'decimal:6',
        'fee_percentage' => 'decimal:6',
        'total_repaid' => 'decimal:2',
        'principal_repaid' => 'decimal:2',
        'interest_repaid' => 'decimal:2',
        'fees_repaid' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'total_amount_due' => 'decimal:2',
        'due_date' => 'date',
        'maturity_date' => 'date',
        'disbursed_at' => 'datetime',
        'first_payment_due' => 'datetime',
        'last_payment_date' => 'datetime',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($disbursement) {
            if (empty($disbursement->disbursement_number)) {
                $disbursement->disbursement_number = static::generateDisbursementNumber();
            }
        });
    }

    // Relationships
    public function creditApplication(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creditLimit(): BelongsTo
    {
        return $this->belongsTo(CreditLimit::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function disbursedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(CreditRepayment::class);
    }

    public function invoiceFinancing(): HasOne
    {
        return $this->hasOne(InvoiceFinancing::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['disbursed', 'partially_repaid', 'overdue']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                    ->orWhere(function($q) {
                        $q->whereIn('status', ['disbursed', 'partially_repaid'])
                          ->where('due_date', '<', now());
                    });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisbursed($query)
    {
        return $query->whereIn('status', ['disbursed', 'partially_repaid', 'fully_repaid', 'overdue']);
    }

    // Accessors & Mutators
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->disbursement_amount, 2);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->outstanding_balance, 2);
    }

    public function getRepaymentPercentageAttribute(): float
    {
        if ($this->total_amount_due <= 0) {
            return 0;
        }
        
        return ($this->total_repaid / $this->total_amount_due) * 100;
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->outstanding_balance > 0;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'disbursed' => 'bg-green-100 text-green-800',
            'partially_repaid' => 'bg-indigo-100 text-indigo-800',
            'fully_repaid' => 'bg-gray-100 text-gray-800',
            'overdue' => 'bg-red-100 text-red-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            'written_off' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Business Logic Methods
    public function canBeEdited(): bool
    {
        return in_array($this->status, ['pending']);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function canBeDisbursed(): bool
    {
        return $this->status === 'pending';
    }

    public function canReceivePayment(): bool
    {
        return in_array($this->status, ['disbursed', 'partially_repaid', 'overdue']);
    }

    public function calculateInterest(): float
    {
        if ($this->term_months <= 0) {
            return 0;
        }

        $monthlyRate = $this->interest_rate / 12;
        return $this->disbursement_amount * $monthlyRate * $this->term_months;
    }

    public function calculateTotalDue(): float
    {
        return $this->disbursement_amount + $this->calculateInterest() + $this->fee_amount;
    }

    public function updateBalances(): void
    {
        $this->total_interest = $this->calculateInterest();
        $this->total_amount_due = $this->calculateTotalDue();
        $this->outstanding_balance = $this->total_amount_due - $this->total_repaid;
        
        // Update status based on repayment
        if ($this->outstanding_balance <= 0) {
            $this->status = 'fully_repaid';
        } elseif ($this->total_repaid > 0) {
            $this->status = $this->is_overdue ? 'overdue' : 'partially_repaid';
        } elseif ($this->is_overdue) {
            $this->status = 'overdue';
        }

        // Update days overdue
        if ($this->due_date && $this->due_date->isPast() && $this->outstanding_balance > 0) {
            $this->days_overdue = $this->due_date->diffInDays(now());
        } else {
            $this->days_overdue = 0;
        }

        $this->save();
    }

    public function markAsDisbursed(User $disbursedBy, string $transactionId = null): void
    {
        $this->update([
            'status' => 'disbursed',
            'disbursed_at' => now(),
            'disbursed_by' => $disbursedBy->id,
            'transaction_id' => $transactionId,
            'outstanding_balance' => $this->calculateTotalDue(),
        ]);

        // Update credit limit utilization
        if ($this->creditLimit) {
            $this->creditLimit->utilized_amount += $this->disbursement_amount;
            $this->creditLimit->save();
        }
    }

    public function addRepayment(array $paymentData): CreditRepayment
    {
        $repayment = $this->repayments()->create($paymentData);
        
        // Update disbursement balances
        $this->total_repaid += $repayment->payment_amount;
        $this->principal_repaid += $repayment->principal_amount;
        $this->interest_repaid += $repayment->interest_amount;
        $this->fees_repaid += $repayment->fee_amount;
        $this->last_payment_date = $repayment->payment_date;
        
        $this->updateBalances();
        
        return $repayment;
    }

    protected static function generateDisbursementNumber(): string
    {
        $prefix = 'DISB';
        $year = date('Y');
        $month = date('m');
        
        $lastDisbursement = static::where('disbursement_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('disbursement_number', 'desc')
            ->first();

        if ($lastDisbursement) {
            $lastNumber = (int) substr($lastDisbursement->disbursement_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}