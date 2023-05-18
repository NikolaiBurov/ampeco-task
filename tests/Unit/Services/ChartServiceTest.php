<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\ChartMetric;
use App\Models\CryptoSymbol;
use App\Repositories\ChartMetricRepository;
use App\Repositories\CryptoSymbolsRepository;
use App\Services\ChartService;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class ChartServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_if_get_trades_by_symbol_returns_correct_data(): void
    {
        $cryptoSymbolsRepository = $this->createMock(CryptoSymbolsRepository::class);
        $symbol = CryptoSymbol::factory()->create();

        $chartDataCollection = ChartMetric::factory()->withCryptoSymbol($symbol)->count(2)->make();

        $cryptoSymbolsRepository->expects($this->atLeastOnce())
            ->method('findSymbolByName')
            ->with('your_symbol')
            ->willReturn($symbol);

        $chartMetricRepository = $this->createMock(ChartMetricRepository::class);

        $chartMetricRepository->expects($this->atLeastOnce())
            ->method('getChartDataForSymbol')
            ->with($symbol->id)
            ->willReturn($chartDataCollection);

        $priceNotificationService = new ChartService($cryptoSymbolsRepository,$chartMetricRepository);

        $expectedResult = [
            'hours' => json_encode([$chartDataCollection[0]->created_at,$chartDataCollection[1]->created_at]),
            'values' => json_encode([$chartDataCollection[0]->price,$chartDataCollection[1]->price]),
        ];

        $this->assertEquals($expectedResult, $priceNotificationService->getTradesBySymbol('your_symbol'));
    }
}