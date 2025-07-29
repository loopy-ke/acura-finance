<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public User $submittedBy
    ) {
        //
    }
}