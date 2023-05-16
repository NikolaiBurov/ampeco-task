<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Repositories\ChartMetricRepository;
use App\Repositories\CryptoSymbolsRepository;

class ChartService
{
    public function __construct(
        private readonly CryptoSymbolsRepository $cryptoSymbolsRepository,
        private readonly ChartMetricRepository $chartMetricRepository
    ) {
    }

    public function getTradesBySymbol(string $symbol): array
    {
        $hours = [];
        $values = [];

        $symbol = $this->cryptoSymbolsRepository->findSymbolByName($symbol);

        $chartData = $this->chartMetricRepository->getChartDataForSymbol($symbol->id);

        foreach ($chartData as $model) {
            $hours[] = $model->created_at;
            $values[] = $model->price;
        }

        return ['hours' => json_encode($hours), 'values' => json_encode($values)];
    }
}