<?php

namespace LoopyLabs\CreditFinancing\Events;

use LoopyLabs\CreditFinancing\Models\CreditDisbursement;
use LoopyLabs\CreditFinancing\Models\CreditRepayment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public CreditDisbursement $disbursement,
        public CreditRepayment $repayment
    ) {
        //
    }
}