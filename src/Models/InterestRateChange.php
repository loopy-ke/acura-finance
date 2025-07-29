<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\User;

class InterestRateChange extends Model
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'old_rate',
        'new_rate',
        'rate_difference',
        'percentage_change',
        'effective_date',
        'change_reason',
        'change_notes',
        'change_type',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'applied_at',
        'batch_id',
        'affected_entities',
        'applications_affected',
        'disbursements_affected',
        'total_amount_affected',
    ];

    protected $casts = [
        'old_rate' => 'decimal:6',
        'new_rate' => 'decimal:6',
        'rate_difference' => 'decimal:6',
        'percentage_change' => 'decimal:4',
        'effective_date' => 'datetime',
        'approved_at' => 'datetime',
        'applied_at' => 'datetime',
        'affected_entities' => 'array',
        'applications_affected' => 'integer',
        'disbursements_affected' => 'integer',
        'total_amount_affected' => 'decimal:2',
    ];

    // Relationships
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function entity(): MorphTo
    {
        return $this->morphTo('entity', 'entity_type', 'entity_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeApplied($query)
    {
        return $query->where('status', 'applied');
    }

    public function scopeForEntity($query, string $entityType, $entityId = null)
    {
        return $query->where('entity_type', $entityType)
                    ->when($entityId !== null, function ($q) use ($entityId) {
                        return $q->where('entity_id', $entityId);
                    });
    }

    public function scopeInBatch($query, string $batchId)
    {
        return $query->where('batch_id', $batchId);
    }

    // Accessors
    public function getFormattedOldRateAttribute(): string
    {
        return number_format($this->old_rate * 100, 2) . '%';
    }

    public function getFormattedNewRateAttribute(): string
    {
        return number_format($this->new_rate * 100, 2) . '%';
    }

    public function getFormattedRateDifferenceAttribute(): string
    {
        $sign = $this->rate_difference >= 0 ? '+' : '';
        return $sign . number_format($this->rate_difference * 100, 2) . '%';
    }

    public function getFormattedPercentageChangeAttribute(): string
    {
        $sign = $this->percentage_change >= 0 ? '+' : '';
        return $sign . number_format($this->percentage_change, 2) . '%';
    }

    public function getIsIncreaseAttribute(): bool
    {
        return $this->rate_difference > 0;
    }

    public function getIsDecreaseAttribute(): bool
    {
        return $this->rate_difference < 0;
    }

    // Methods
    public function approve(User $approver): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->update([
            'status' => 'approved',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);

        return true;
    }

    public function reject(User $approver, string $reason = null): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->update([
            'status' => 'rejected',
            'approved_by' => $approver->id,
            'approved_at' => now(),
            'change_notes' => $this->change_notes . "\n\nRejection reason: " . $reason,
        ]);

        return true;
    }

    public function apply(): bool
    {
        if ($this->status !== 'approved') {
            return false;
        }

        $this->update([
            'status' => 'applied',
            'applied_at' => now(),
        ]);

        return true;
    }

    public function cancel(string $reason = null): bool
    {
        if (in_array($this->status, ['applied', 'rejected'])) {
            return false;
        }

        $this->update([
            'status' => 'cancelled',
            'change_notes' => $this->change_notes . "\n\nCancellation reason: " . $reason,
        ]);

        return true;
    }

    // Calculate rate differences automatically
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->old_rate !== null && $model->new_rate !== null) {
                $model->rate_difference = $model->new_rate - $model->old_rate;
                
                if ($model->old_rate > 0) {
                    $model->percentage_change = (($model->new_rate - $model->old_rate) / $model->old_rate) * 100;
                } else {
                    $model->percentage_change = 0;
                }
            }
        });
    }
}