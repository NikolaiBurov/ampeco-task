<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ChartController;
use App\Models\CryptoSymbol;
use App\Services\ChartService;
use App\Services\PriceNotificationService;
use Carbon\Carbon;
use Illuminate\View\View;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class ChartControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_index_method_returns_correct_response(): void
    {
        $now = Carbon::now();
        $chartServiceMock = $this->createMock(ChartService::class);
        $chartServiceMock->expects($this->atLeastOnce())
            ->method('getTradesBySymbol')
            ->with(CryptoSymbol::BTCN_SYMBOL)
            ->willReturn(
                [
                    'hours' => [
                        $now->addMinutes()->toDateString(),
                        $now->addMinutes(2)->toDateString(),
                        $now->addMinutes(3)->toDateString()
                    ],
                    'values' => [10000.000, 20000.000, 30000.000]
                ]
            );

        $controller = new ChartController($chartServiceMock, $this->createMock(PriceNotificationService::class));

        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('chart.index', $response->name());
        $this->assertArrayHasKey('chartData', $response->getData());
    }

    public function test_price_notification_method_returns_correct_response(): void
    {
        $priceService = resolve(PriceNotificationService::class);

        $formData = [
            'email' => 'test@example.com',
            'price_limit' => '27.000',
        ];

        $response = $this->post(route('charts.create-price-notification'), $formData);

        $response->assertSessionHas('message', 'Successfully saved data !');

        $this->assertDatabaseHas('price_notifications', [
            'email' => $formData['email'],
            'price_limit' => $priceService->formatPrice($formData['price_limit']),
        ]);
    }

    public function test_price_notification_method_returns_error_on_validation_error(): void
    {
        $formData = [
            'email' => 'fakemail',
            'price_limit' => '-1',
        ];

        $response = $this->post(route('charts.create-price-notification'), $formData);

        $response->assertSessionHasErrors('email', 'The email field must be a valid email address.');
        $response->assertSessionHasErrors('price_limit', 'The price limit field must be at least 1.');
    }
}