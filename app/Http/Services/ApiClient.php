<?php
declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    private const API_URL = 'https://api.bitfinex.com/v1/pubticker/';

    public static function getLastOrderBySymbol(string $symbol): string
    {
        return Http::get(sprintf('%s%s', self::API_URL, $symbol))->body();
    }
}