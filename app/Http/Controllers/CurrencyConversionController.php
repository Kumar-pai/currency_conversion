<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\CurrencyConversionService\BankAbstractFactory;

/**
 * @group  Currency Conversion
 */
class CurrencyConversionController extends Controller
{
    /**
     * Currency Conversion
     *
     * @queryParam origin_currency required The origin_currency of origin currency enum('TWD', 'USD', 'JPY'). Example: TWD
     * @queryParam target_currency required The target_currency of target currency enum('TWD', 'USD', 'JPY'). Example: USD
     * @queryParam amount required The amount of conversion amount. Example: 500.2
     *
     * @response  400 {
     *  "message": {
     *       "origin_currency": [
     *          "The origin currency field is required."
     *       ],
     *       "target_currency": [
     *          "The target currency field is required."
     *       ],
     *       "amount": [
     *          "The amount field is required."
     *       ]
     *  }
     * }
     *
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin_currency' => 'required|string|in:TWD,JPY,USD',
            'target_currency' => 'required|string|in:TWD,JPY,USD',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $params = $request->only([
            'origin_currency',
            'target_currency',
            'amount',
        ]);

        $bankAbstractFactory = new BankAbstractFactory(BankAbstractFactory::ASIA_YO_BANK);
        $convertAmount = $bankAbstractFactory->convertAmount($params);

        return response()->json(['convert_amount' => $convertAmount], 200);
    }
}
