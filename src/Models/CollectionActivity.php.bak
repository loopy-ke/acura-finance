<?php

namespace LoopyLabs\CreditFinancing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;
use App\Models\User;

class CollectionActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_case_id',
        'customer_id',
        'activity_type',
        'outcome',
        'activity_notes',
        'activity_date',
        'follow_up_date',
        'payment_promise_amount',
        'payment_promise_date',
        'contact_method',
        'contact_person',
        'phone_number',
        'email_address',
        'performed_by',
        'attachments',
        'metadata',
    ];

    protected $casts = [
        'payment_promise_amount' => 'decimal:2',
        'activity_date' => 'datetime',
        'follow_up_date' => 'datetime',
        'payment_promise_date' => 'date',
        'attachments' => 'array',
        'metadata' => 'array',
    ];

    // Relationships
    public function collectionCase(): BelongsTo
    {
        return $this->belongsTo(CollectionCase::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    // Scopes
    public function scopeByType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeByOutcome($query, string $outcome)
    {
        return $query->where('outcome', $outcome);
    }

    public function scopeWithPromiseToPay($query)
    {
        return $query->where('outcome', 'promise_to_pay')
                    ->whereNotNull('payment_promise_date');
    }

    public function scopeRequiringFollowUp($query)
    {
        return $query->whereNotNull('follow_up_date')
                    ->where('follow_up_date', '<=', now());
    }

    // Accessors
    public function getActivityTypeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->activity_type));
    }

    public function getOutcomeDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->outcome));
    }

    public function getOutcomeColorAttribute(): string
    {
        return match($this->outcome) {
            'contact_made' => 'bg-blue-100 text-blue-800',
            'payment_received' => 'bg-green-100 text-green-800',
            'promise_to_pay' => 'bg-yellow-100 text-yellow-800',
            'no_contact' => 'bg-gray-100 text-gray-800',
            'refusal_to_pay' => 'bg-red-100 text-red-800',
            'dispute_raised' => 'bg-orange-100 text-orange-800',
            'hardship_claimed' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Business Logic Methods
    public function isPromiseToPay(): bool
    {
        return $this->outcome === 'promise_to_pay' && 
               $this->payment_promise_date !== null;
    }

    public function isPromiseOverdue(): bool
    {
        return $this->isPromiseToPay() && 
               $this->payment_promise_date->isPast();
    }

    public function requiresFollowUp(): bool
    {
        return $this->follow_up_date !== null && 
               $this->follow_up_date->isPast();
    }
}