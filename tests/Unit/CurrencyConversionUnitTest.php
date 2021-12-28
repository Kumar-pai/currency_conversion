<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Services\CurrencyConversionService\AsiaYoBank;
use App\Services\CurrencyConversionService\BankAbstractFactory;

class CurrencyConversionUnitTest extends TestCase
{
    public function testBankAbstractFactory()
    {
        $bankAbstractFactory = new BankAbstractFactory(BankAbstractFactory::ASIA_YO_BANK);
        $this->assertEquals(AsiaYoBank::class, get_class($bankAbstractFactory->bankType));

        try {
            $bankAbstractFactory = new BankAbstractFactory('Test');
        } catch (\Exception $e) {
            $this->assertEquals("Invalid bank type for bank abstract factory", $e->getMessage());
        }
    }

    /**
     * @dataProvider addCurrencyConversionData
     */
    public function testCurrencyConversion($originCurrency, $targetCurrency, $amount, $validationConvertAmount)
    {
        $params['origin_currency'] = $originCurrency;
        $params['target_currency'] = $targetCurrency;
        $params['amount'] = $amount;

        $bankAbstractFactory = new BankAbstractFactory(BankAbstractFactory::ASIA_YO_BANK);
        $convertAmount = $bankAbstractFactory->convertAmount($params);
        $this->assertEquals($validationConvertAmount, $convertAmount);
    }

    public function addCurrencyConversionData()
    {
        $bankAbstractFactory = new BankAbstractFactory(BankAbstractFactory::ASIA_YO_BANK);
        $exchangeRate = $bankAbstractFactory->bankType->exchangeRate;
        $originCurrencyData = ['TWD', 'JPY', 'USD'];
        $targetCurrencyData = ['TWD', 'JPY', 'USD'];

        $testData = [];

        for ($i = 0; $i < 30; $i++) {
            $originCurrency = $originCurrencyData[array_rand($originCurrencyData)];

            $targetCurrency = $targetCurrencyData[array_rand($targetCurrencyData)];

            $amount = rand(100, 10000);

            $convertAmount = round($exchangeRate[$originCurrency][$targetCurrency] * $amount, 2);

            $convertAmountWithFormat = number_format($convertAmount, 2, '.', ',');
            $testData[] = [$originCurrency, $targetCurrency, $amount, $convertAmountWithFormat];
        }

        return $testData;
    }
}
