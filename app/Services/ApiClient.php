<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    public const BIT_FINEX_API_URL = 'https://api.bitfinex.com/v1/pubticker/';

    public static function getLastOrderBySymbol(string $symbol): string
    {
        return Http::get(sprintf('%s%s', self::BIT_FINEX_API_URL, $symbol))->body();
    }
}