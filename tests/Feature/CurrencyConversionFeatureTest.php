<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionFeatureTest extends TestCase
{
    public function testHttpStatus()
    {
        $route = '/api/currency-conversion';
        $response = $this->get($route);
        $response->assertStatus(400)->assertJson([
            'message' => [
                'origin_currency' => true,
                'target_currency' => true,
                'amount' => true,
            ],
        ]);

        $route .= '?origin_currency=TWD';
        $response = $this->get($route);
        $response->assertStatus(400)
            ->assertJson([
                'message' => [
                    'target_currency' => true,
                    'amount' => true,
                ],
            ]);

        $route .= '&target_currency=TWD';
        $response = $this->get($route);
        $response->assertStatus(400)
            ->assertJson([
                'message' => [
                    'amount' => true,
                ],
            ]);

        $route .= '&amount=1000';
        $response = $this->get($route);
        $response->assertStatus(200)
            ->assertJson([
                'convert_amount' => true
            ]);
    }

    public function testAPIValidator()
    {
        $route = '/api/currency-conversion';
        $response = $this->get($route);
        $response->assertJsonPath('message.origin_currency', ['The origin currency field is required.'])
            ->assertJsonPath('message.target_currency', ['The target currency field is required.'])
            ->assertJsonPath('message.amount', ['The amount field is required.']);

        $route .= '?origin_currency=RMB';
        $response = $this->get($route);
        $response->assertJsonPath('message.origin_currency', ['The selected origin currency is invalid.']);

        $route .= '&target_currency=RMB';
        $response = $this->get($route);
        $response->assertJsonPath('message.target_currency', ['The selected target currency is invalid.']);

        $route .= '&amount=String';
        $response = $this->get($route);
        $response->assertJsonPath('message.amount', ['The amount must be a number.']);
    }
}
