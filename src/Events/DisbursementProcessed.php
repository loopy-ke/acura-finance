<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DisbursementProcessed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditDisbursement $disbursement,
        public User $processedBy
    ) {
        //
    }
}