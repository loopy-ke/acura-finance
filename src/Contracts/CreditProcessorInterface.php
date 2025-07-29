<?php

namespace LoopyLabs\CreditFinancing\Contracts;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use LoopyLabs\CreditFinancing\Models\CreditDecision;
use App\Models\Customer;

interface CreditProcessorInterface
{
    public function processApplication(CreditApplication $application): CreditDecision;
    
    public function checkCreditLimit(Customer $customer, float $amount): bool;
    
    public function approveCredit(CreditApplication $application, array $terms): CreditDecision;
    
    public function denyCredit(CreditApplication $application, string $reason): CreditDecision;
    
    public function calculateTerms(CreditApplication $application): array;
    
    public function validateApplication(CreditApplication $application): array;
}