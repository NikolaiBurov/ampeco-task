<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\CryptoSymbol;
use App\Services\ApiClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiClientTest extends TestCase
{
    public function test_get_last_order_by_symbol()
    {
        $responseBody = '{"mid":"26949.5","bid":"26949.0","ask":"26950.0","last_price":"26949.0","low":"26413.0","high":"27429.0","volume":"1133.10339944","timestamp":"1684499796.3806324"}';

        Http::fake([
            sprintf('%s%s', ApiClient::BIT_FINEX_API_URL, CryptoSymbol::BTCN_SYMBOL) => Http::response(
                $responseBody,
                200
            ),
        ]);

        $result = ApiClient::getLastOrderBySymbol(CryptoSymbol::BTCN_SYMBOL);

        Http::assertSent(function ($request) {
            return $request->url() === sprintf('%s%s', ApiClient::BIT_FINEX_API_URL, CryptoSymbol::BTCN_SYMBOL);
        });

        $this->assertSame($responseBody, $result);
    }
}