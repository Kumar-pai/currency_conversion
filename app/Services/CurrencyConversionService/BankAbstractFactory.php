<?php

namespace App\Services\CurrencyConversionService;

use App\Services\CurrencyConversionService\AsiaYoBank;

class BankAbstractFactory
{
    //bank name
    const ASIA_YO_BANK = 'asia_yo_bank';

    public function __construct(string $bankType)
    {
        $this->bankType = null;

        switch ($bankType) {
            case self::ASIA_YO_BANK:
                $this->bankType =  new AsiaYoBank();
                break;
            default:
                throw new \Exception('Invalid bank type for bank abstract factory');
        }
    }

    public function convertAmount($params) : string
    {
        return $this->bankType->convertAmount($params);
    }
}
