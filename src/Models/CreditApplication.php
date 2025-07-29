<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class CreditApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'customer_id',
        'credit_product_id',
        'invoice_id',
        'created_by',
        'requested_amount',
        'requested_term_months',
        'purpose',
        'business_justification',
        'status',
        'submission_date',
        'review_started_at',
        'decision_date',
        'credit_score_at_application',
        'automated_decision',
        'automated_decision_reason',
        'external_application_id',
        'external_status',
        'external_response',
        'approved_amount',
        'approved_term_months',
        'approved_interest_rate',
        'approved_fee_percentage',
        'requires_manual_approval',
        'approved_by',
        'denied_by',
        'denial_reason',
        'expires_at',
    ];

    protected $casts = [
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'approved_interest_rate' => 'decimal:4',
        'approved_fee_percentage' => 'decimal:4',
        'submission_date' => 'datetime',
        'review_started_at' => 'datetime',
        'decision_date' => 'datetime',
        'expires_at' => 'datetime',
        'requires_manual_approval' => 'boolean',
        'external_response' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->application_number)) {
                $model->application_number = static::generateApplicationNumber();
            }
            if (empty($model->expires_at)) {
                $model->expires_at = now()->addDays(config('credit-financing.approval.application_expiry_days', 30));
            }
        });
    }

    protected static function generateApplicationNumber(): string
    {
        $prefix = 'CA';
        $year = date('Y');
        $month = date('m');
        
        $lastApplication = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
            
        $sequence = $lastApplication ? 
            intval(substr($lastApplication->application_number, -4)) + 1 : 1;
            
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }


    public function invoice(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function deniedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'denied_by');
    }

    public function creditProduct(): BelongsTo
    {
        return $this->belongsTo(CreditProduct::class);
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(CreditDecision::class);
    }

    public function financedInvoices(): HasMany
    {
        return $this->hasMany(FinancedInvoice::class);
    }

    public function disbursements(): HasMany
    {
        return $this->hasMany(CreditDisbursement::class);
    }

    public function latestDecision(): HasOne
    {
        return $this->hasOne(CreditDecision::class)->latestOfMany();
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['draft', 'submitted', 'under_review']);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeDenied($query)
    {
        return $query->where('status', 'denied');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())
            ->whereIn('status', ['draft', 'submitted', 'under_review']);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast() && 
            in_array($this->status, ['draft', 'submitted', 'under_review']);
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['draft', 'submitted', 'under_review']);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isDenied(): bool
    {
        return $this->status === 'denied';
    }

    public function canBeApproved(): bool
    {
        return $this->status === 'under_review' && !$this->isExpired();
    }

    public function canBeDenied(): bool
    {
        return in_array($this->status, ['submitted', 'under_review']) && !$this->isExpired();
    }

    public function getApprovalPercentageAttribute(): float
    {
        if (!$this->requested_amount || !$this->approved_amount) {
            return 0;
        }
        
        return ($this->approved_amount / $this->requested_amount) * 100;
    }

    public function getDaysToDecisionAttribute(): ?int
    {
        if (!$this->submission_date || !$this->decision_date) {
            return null;
        }
        
        return $this->submission_date->diffInDays($this->decision_date);
    }
}