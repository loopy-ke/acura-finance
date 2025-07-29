<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditDecision;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public User $approvedBy,
        public CreditDecision $decision
    ) {
        //
    }
}