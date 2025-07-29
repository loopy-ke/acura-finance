<?php

namespace LoopyLabs\CreditFinancing\Contracts;

use LoopyLabs\CreditFinancing\Models\CreditApplication;
use App\Models\Customer;

interface CreditScoringInterface
{
    public function scoreApplication(CreditApplication $application): array;
    
    public function scoreCustomer(Customer $customer): array;
    
    public function getScoreBreakdown(Customer $customer): array;
    
    public function updateCustomerScore(Customer $customer): int;
}