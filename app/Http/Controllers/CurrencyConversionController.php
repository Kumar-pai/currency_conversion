<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\CurrencyConversionService\BankAbstractFactory;

class CurrencyConversionController extends Controller
{
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
