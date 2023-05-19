<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Mail\NotificationsExceedingPrice;
use App\Models\PriceNotification;
use App\Repositories\PriceNotificationRepository;
use App\Services\PriceNotificationService;
use Faker\Factory;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class PriceNotificationServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_if_service_creates_price_notification(): void
    {
        $formData = [
            'email' => Factory::create()->email(),
            'price_limit' => '26.000',
        ];

        $service = new PriceNotificationService(new PriceNotificationRepository());
        $result = $service->updateOrCreateNotification($formData);

        $this->assertInstanceOf(PriceNotification::class, $result);
        $this->assertDatabaseHas('price_notifications', [
            'email' => $formData['email'],
            'price_limit' => $service->formatPrice($formData['price_limit'])
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_if_service_updates_price_notification(): void
    {
        $formData = [
            'email' => Factory::create()->email(),
            'price_limit' => '27.500',
        ];

        $priceNotification = PriceNotification::factory()->withEmail($formData['email'])->create();

        $service = new PriceNotificationService(new PriceNotificationRepository());
        $result = $service->updateOrCreateNotification($formData);

        $this->assertInstanceOf(PriceNotification::class, $result);
        $this->assertDatabaseHas('price_notifications', [
            'id' => $priceNotification->id,
            'email' => $formData['email'],
            'price_limit' => $service->formatPrice($formData['price_limit']),
        ]);
    }

    public function test_format_price(): void
    {
        $service = new PriceNotificationService(new PriceNotificationRepository());
        $inputPrice = '26.000';

        $result = $service->formatPrice($inputPrice);

        $this->assertSame(26000.00, $result);
    }

    public function test_send_email(): void
    {
        $notifications = PriceNotification::factory()->count(20)->make();

        Mail::fake();

        $service = new PriceNotificationService(new PriceNotificationRepository());
        $service->sendEmails($notifications);

        Mail::assertQueued(NotificationsExceedingPrice::class, function ($mail) use ($notifications) {
            return $mail->hasTo($notifications->pluck('email')->all());
        });

        Mail::assertQueued(NotificationsExceedingPrice::class, 20);
    }
}