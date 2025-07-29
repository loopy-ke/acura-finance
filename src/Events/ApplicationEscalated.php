<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationEscalated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public string $fromLevel,
        public string $toLevel
    ) {
        //
    }
}