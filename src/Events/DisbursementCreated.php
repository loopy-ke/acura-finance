<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DisbursementCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditDisbursement $disbursement
    ) {
        //
    }
}