<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\CollectChartDataCommand;
use App\DTO\ChartDataDTO;
use App\Models\CryptoSymbol;
use App\Repositories\ChartMetricRepository;
use App\Repositories\CryptoSymbolsRepository;
use App\Repositories\PriceNotificationRepository;
use App\Services\PriceNotificationService;
use App\Services\Serializer;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class CollectChartDataCommandTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_if_handle_method_saves_data_from_api_correctly(): void
    {
        $bitcoinSymbol = CryptoSymbol::factory()->create();

        $dto = new ChartDataDTO([
            "mid" => "27398.5",
            "bid" => "27398.0",
            "ask" => "27399.0",
            "last_price" => "20000.000",
            "low" => "26612.0",
            "high" => "27532.0",
            "volume" => "862.74257269",
            "timestamp" => "1684406058.2191012",
        ],
        );

        $cryptoSymbolsRepositoryMock = $this->createMock(CryptoSymbolsRepository::class);

        $cryptoSymbolsRepositoryMock->method('findSymbolByName')
            ->willReturn($bitcoinSymbol);

        $priceNotificationServiceMock = $this->createMock(PriceNotificationService::class);

        $priceNotificationServiceMock->expects($this->any())->method('sendEmails');

        $serializerMock = $this->createMock(Serializer::class);

        $serializerMock->method('deserializeToDTO')->willReturn($dto);

        $command = new CollectChartDataCommand(
            $serializerMock,
            $cryptoSymbolsRepositoryMock,
            resolve(ChartMetricRepository::class),
            $priceNotificationServiceMock,
            resolve(PriceNotificationRepository::class),
        );

        $command->handle();

        $this->assertDatabaseHas('chart_metrics', [
            'price' => $dto->getPrice()
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_if_handle_method_logs_exception(): void
    {
        $chartMetricRepositoryMock = $this->createMock(ChartMetricRepository::class);

        $chartMetricRepositoryMock->expects($this->atMost(1))->method('save');

        $priceNotificationServiceMock = $this->createMock(PriceNotificationService::class);

        $serializerMock = $this->createMock(Serializer::class);

        Log::shouldReceive('error')
            ->atLeast()
            ->with('DB ERROR');

        $command = new CollectChartDataCommand(
            $serializerMock,
            resolve(CryptoSymbolsRepository::class),
            $chartMetricRepositoryMock,
            $priceNotificationServiceMock,
            resolve(PriceNotificationRepository::class),
        );

        $command->handle();
    }
}