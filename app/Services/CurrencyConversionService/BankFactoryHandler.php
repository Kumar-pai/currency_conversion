<?php

namespace App\Services\CurrencyConversionService;

class BankFactoryHandler
{
    protected function calculateAmount(float $amount, float $exchangeRate) : float
    {
        return round($amount * $exchangeRate, 2);
    }

    protected function transformFormat(float $amount) :string
    {
        return number_format($amount, 2, '.', ',');
    }
}
