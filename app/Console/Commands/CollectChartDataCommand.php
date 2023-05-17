<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CryptoSymbol;
use App\Repositories\ChartMetricRepository;
use App\Repositories\CryptoSymbolsRepository;
use App\Repositories\PriceNotificationRepository;
use App\Services\ApiClient;
use App\Services\PriceNotificationService;
use App\Services\Serializer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CollectChartDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:collect-chart-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job that will collect data from bitfinex api for bitcoin trades';


    public function __construct(
        private readonly Serializer $serializer,
        private readonly CryptoSymbolsRepository $cryptoSymbolsRepository,
        private readonly ChartMetricRepository $chartMetricRepository,
        private readonly PriceNotificationService $priceNotificationService,
        private readonly PriceNotificationRepository $priceNotificationRepository
    ) {
        parent::__construct();
    }

    /**
     * In the future we can use the crypto symbols table to add other crypto trades
     */
    public function handle(): void
    {
        try {
            $cryptoSymbol = $this->cryptoSymbolsRepository->findSymbolByName(CryptoSymbol::BTCN_SYMBOL);
            $lastOrder = ApiClient::getLastOrderBySymbol($cryptoSymbol->name);
            $data = $this->serializer->deserializeToDTO($lastOrder);

            $notificationsExceedingPriceQuery = $this->priceNotificationRepository->getNotificationsExceedingPriceQuery(
                $data->getPrice()
            );

            if ($notificationsExceedingPriceQuery->exists()) {
                $this->priceNotificationService->sendEmails($notificationsExceedingPriceQuery->get());
            }

            $this->chartMetricRepository->save($data, $cryptoSymbol);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
