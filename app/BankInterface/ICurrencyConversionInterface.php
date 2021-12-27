<?php

namespace App\BankInterface;

interface ICurrencyConversionInterface
{
    public function convertAmount($params);
}

