<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class CollectionCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_number',
        'credit_disbursement_id',
        'customer_id',
        'priority',
        'status',
        'original_amount',
        'outstanding_amount',
        'collected_amount',
        'fees_charged',
        'penalties_charged',
        'total_recoverable',
        'days_overdue',
        'overdue_since',
        'last_payment_date',
        'next_action_date',
        'collection_attempts',
        'assigned_to',
        'assigned_at',
        'collection_stage',
        'resolution_type',
        'resolved_at',
        'resolved_by',
        'created_by',
        'case_notes',
        'metadata',
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'fees_charged' => 'decimal:2',
        'penalties_charged' => 'decimal:2',
        'total_recoverable' => 'decimal:2',
        'overdue_since' => 'date',
        'last_payment_date' => 'date',
        'next_action_date' => 'date',
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($case) {
            if (empty($case->case_number)) {
                $case->case_number = static::generateCaseNumber();
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

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(CollectionActivity::class);
    }

    public function paymentPlans(): HasMany
    {
        return $this->hasMany(PaymentPlan::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAssignedTo($query, User $user)
    {
        return $query->where('assigned_to', $user->id);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByStage($query, string $stage)
    {
        return $query->where('collection_stage', $stage);
    }

    public function scopeOverdue($query, int $days = null)
    {
        $query = $query->where('status', 'active');
        
        if ($days) {
            return $query->where('days_overdue', '>=', $days);
        }
        
        return $query->where('days_overdue', '>', 0);
    }

    public function scopeRequiresAction($query)
    {
        return $query->where('status', 'active')
                    ->where(function($q) {
                        $q->whereNull('next_action_date')
                          ->orWhere('next_action_date', '<=', now());
                    });
    }

    // Accessors
    public function getFormattedOutstandingAmountAttribute(): string
    {
        return number_format($this->outstanding_amount, 2);
    }

    public function getRecoveryPercentageAttribute(): float
    {
        if ($this->original_amount <= 0) {
            return 0;
        }
        
        return ($this->collected_amount / $this->original_amount) * 100;
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'bg-blue-100 text-blue-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            'legal' => 'bg-red-100 text-red-800',
            'written_off' => 'bg-gray-100 text-gray-800',
            'suspended' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStageColorAttribute(): string
    {
        return match($this->collection_stage) {
            'early_stage' => 'bg-green-100 text-green-800',
            'middle_stage' => 'bg-yellow-100 text-yellow-800',
            'late_stage' => 'bg-orange-100 text-orange-800',
            'legal_stage' => 'bg-red-100 text-red-800',
            'write_off_stage' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Business Logic Methods
    public function canBeResolved(): bool
    {
        return in_array($this->status, ['active']);
    }

    public function canBeReassigned(): bool
    {
        return in_array($this->status, ['active']);
    }

    public function canEscalateToLegal(): bool
    {
        return $this->status === 'active' && 
               $this->collection_stage !== 'legal_stage' &&
               $this->days_overdue >= setting('credit_financing.legal_escalation_days', 180);
    }

    public function updateDaysOverdue(): void
    {
        if ($this->overdue_since) {
            $this->days_overdue = $this->overdue_since->diffInDays(now());
            $this->updateCollectionStage();
            $this->save();
        }
    }

    public function updateCollectionStage(): void
    {
        $stage = match(true) {
            $this->days_overdue <= 30 => 'early_stage',
            $this->days_overdue <= 90 => 'middle_stage',
            $this->days_overdue <= 180 => 'late_stage',
            $this->days_overdue > 180 => 'legal_stage',
            default => 'early_stage',
        };

        if ($this->collection_stage !== $stage) {
            $this->collection_stage = $stage;
            $this->updatePriority();
        }
    }

    public function updatePriority(): void
    {
        $priority = match($this->collection_stage) {
            'early_stage' => $this->outstanding_amount > 100000 ? 'medium' : 'low',
            'middle_stage' => 'medium',
            'late_stage' => 'high',
            'legal_stage' => 'urgent',
            'write_off_stage' => 'low',
            default => 'medium',
        };

        $this->priority = $priority;
    }

    public function assignTo(User $user): void
    {
        $this->update([
            'assigned_to' => $user->id,
            'assigned_at' => now(),
        ]);
    }

    public function recordActivity(array $activityData): CollectionActivity
    {
        $activity = $this->activities()->create(array_merge($activityData, [
            'customer_id' => $this->customer_id,
            'performed_by' => auth()->id(),
        ]));

        // Update collection attempts
        $this->increment('collection_attempts');

        // Update next action date if provided
        if (isset($activityData['follow_up_date'])) {
            $this->update(['next_action_date' => $activityData['follow_up_date']]);
        }

        return $activity;
    }

    public function recordPayment(float $amount): void
    {
        $this->collected_amount += $amount;
        $this->outstanding_amount -= $amount;
        $this->last_payment_date = now();

        // Check if case should be resolved
        if ($this->outstanding_amount <= 0) {
            $this->status = 'resolved';
            $this->resolution_type = 'full_payment';
            $this->resolved_at = now();
            $this->resolved_by = auth()->id();
        }

        $this->save();
    }

    public function escalateToLegal(): void
    {
        $this->update([
            'status' => 'legal',
            'collection_stage' => 'legal_stage',
            'priority' => 'urgent',
        ]);
    }

    public function writeOff(): void
    {
        $this->update([
            'status' => 'written_off',
            'collection_stage' => 'write_off_stage',
            'resolution_type' => 'written_off',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);
    }

    protected static function generateCaseNumber(): string
    {
        $prefix = 'COLL';
        $year = date('Y');
        $month = date('m');
        
        $lastCase = static::where('case_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('case_number', 'desc')
            ->first();

        if ($lastCase) {
            $lastNumber = (int) substr($lastCase->case_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}