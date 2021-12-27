<?php

namespace App\Services\CurrencyConversionService;

use App\BankInterface\ICurrencyConversionInterface;
use App\Services\CurrencyConversionService\BankFactoryHandler;

class AsiaYoBank extends BankFactoryHandler implements ICurrencyConversionInterface
{
    public $exchangeRate = [
        'TWD' => [
            'TWD' => 1,
            'JPY' => 3.669,
            'USD' => 0.03281,
        ],
        'JPY' => [
            'TWD' => 0.26956,
            'JPY' => 1,
            'USD' => 0.00885,
        ],
        'USD' => [
            'TWD' => 30.444,
            'JPY' => 111.801,
            'USD' => 1,
        ],
    ];

    public function convertAmount($params) : string
    {

        $conversionAmount = $this->calculateAmount(
            $params['amount'],
            $this->exchangeRate[$params['origin_currency']][$params['target_currency']]
        );

         return $this->transformFormat($conversionAmount);
    }
}
