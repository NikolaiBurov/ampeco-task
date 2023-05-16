<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\ChartDataDTO;
use App\Models\ChartMetric;
use App\Models\CryptoSymbol;
use Illuminate\Support\Collection;

class ChartMetricRepository
{
    public function save(ChartDataDTO $data, CryptoSymbol $symbol): void
    {
        ChartMetric::create([
            'price' => $data->getPrice(),
            'crypto_symbol_id' => $symbol->id,
            'created_at' => $data->getCreatedAt()
        ]);
    }


    public function getChartDataForSymbol(int $cryptoSymbolId): Collection
    {
        return ChartMetric::query()
            ->where('crypto_symbol_id', '=', $cryptoSymbolId)
            ->orderBy('created_at')
            ->get();
    }
}