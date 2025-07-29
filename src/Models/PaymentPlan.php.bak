<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class PaymentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_number',
        'collection_case_id',
        'customer_id',
        'credit_disbursement_id',
        'status',
        'total_amount',
        'down_payment',
        'installment_amount',
        'number_of_installments',
        'frequency',
        'start_date',
        'end_date',
        'next_payment_date',
        'installments_paid',
        'amount_paid',
        'outstanding_balance',
        'missed_payments',
        'last_payment_date',
        'created_by',
        'approved_by',
        'approved_at',
        'terms_and_conditions',
        'plan_notes',
        'metadata',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'next_payment_date' => 'date',
        'last_payment_date' => 'date',
        'approved_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (empty($plan->plan_number)) {
                $plan->plan_number = static::generatePlanNumber();
            }
        });
    }

    // Relationships
    public function collectionCase(): BelongsTo
    {
        return $this->belongsTo(CollectionCase::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creditDisbursement(): BelongsTo
    {
        return $this->belongsTo(CreditDisbursement::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefaulted($query)
    {
        return $query->where('status', 'defaulted');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDueForPayment($query)
    {
        return $query->where('status', 'active')
                    ->where('next_payment_date', '<=', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('next_payment_date', '<', now());
    }

    // Accessors
    public function getFormattedInstallmentAmountAttribute(): string
    {
        return number_format($this->installment_amount, 2);
    }

    public function getFormattedOutstandingBalanceAttribute(): string
    {
        return number_format($this->outstanding_balance, 2);
    }

    public function getCompletionPercentageAttribute(): float
    {
        if ($this->number_of_installments <= 0) {
            return 0;
        }
        
        return ($this->installments_paid / $this->number_of_installments) * 100;
    }

    public function getPaymentPercentageAttribute(): float
    {
        if ($this->total_amount <= 0) {
            return 0;
        }
        
        return ($this->amount_paid / $this->total_amount) * 100;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'proposed' => 'bg-blue-100 text-blue-800',
            'accepted' => 'bg-yellow-100 text-yellow-800',
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'defaulted' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getRemainingInstallmentsAttribute(): int
    {
        return max(0, $this->number_of_installments - $this->installments_paid);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'active' && 
               $this->next_payment_date && 
               $this->next_payment_date->isPast();
    }

    // Business Logic Methods
    public function canBeApproved(): bool
    {
        return $this->status === 'proposed';
    }

    public function canReceivePayment(): bool
    {
        return in_array($this->status, ['active']);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['proposed', 'accepted', 'active']);
    }

    public function approve(User $approver): void
    {
        $this->update([
            'status' => 'accepted',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);
    }

    public function activate(): void
    {
        $this->update([
            'status' => 'active',
        ]);
    }

    public function recordPayment(float $amount, Carbon $paymentDate = null): void
    {
        $paymentDate = $paymentDate ?? now();
        
        $this->amount_paid += $amount;
        $this->outstanding_balance -= $amount;
        $this->last_payment_date = $paymentDate;
        
        // Check if this covers a full installment
        if ($amount >= $this->installment_amount) {
            $this->installments_paid++;
            $this->updateNextPaymentDate();
        }
        
        // Check if plan is complete
        if ($this->outstanding_balance <= 0 || $this->installments_paid >= $this->number_of_installments) {
            $this->status = 'completed';
        }
        
        $this->save();
    }

    public function recordMissedPayment(): void
    {
        $this->missed_payments++;
        
        // Check if plan should be defaulted
        $maxMissedPayments = setting('credit_financing.max_missed_payments', 2);
        if ($this->missed_payments >= $maxMissedPayments) {
            $this->status = 'defaulted';
        }
        
        $this->save();
    }

    public function generateSchedule(): array
    {
        $schedule = [];
        $currentDate = $this->start_date->copy();
        
        for ($i = 1; $i <= $this->number_of_installments; $i++) {
            $schedule[] = [
                'installment_number' => $i,
                'due_date' => $currentDate->copy(),
                'amount' => $this->installment_amount,
                'is_paid' => $i <= $this->installments_paid,
                'is_overdue' => $currentDate->isPast() && $i > $this->installments_paid,
            ];
            
            $currentDate = $this->getNextPaymentDate($currentDate);
        }
        
        return $schedule;
    }

    protected function updateNextPaymentDate(): void
    {
        if ($this->installments_paid < $this->number_of_installments) {
            $this->next_payment_date = $this->getNextPaymentDate($this->next_payment_date);
        }
    }

    protected function getNextPaymentDate(Carbon $fromDate): Carbon
    {
        return match($this->frequency) {
            'weekly' => $fromDate->copy()->addWeek(),
            'biweekly' => $fromDate->copy()->addWeeks(2),
            'monthly' => $fromDate->copy()->addMonth(),
            default => $fromDate->copy()->addMonth(),
        };
    }

    protected static function generatePlanNumber(): string
    {
        $prefix = 'PLAN';
        $year = date('Y');
        $month = date('m');
        
        $lastPlan = static::where('plan_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('plan_number', 'desc')
            ->first();

        if ($lastPlan) {
            $lastNumber = (int) substr($lastPlan->plan_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}