<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\NotificationsExceedingPrice;
use App\Models\PriceNotification;
use App\Repositories\PriceNotificationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class PriceNotificationService
{
    public function __construct(private readonly PriceNotificationRepository $priceNotificationRepository)
    {
    }

    public function updateOrCreateNotification(array $formData): PriceNotification
    {
        $email = $formData['email'];
        $price = $this->formatPrice($formData['price_limit']);

        return $this->priceNotificationRepository->updateOrCreate(
            ['email' => $email],
            ['email' => $email, 'price_limit' => $price]
        );
    }

    public function formatPrice(string $inputPrice): float
    {
        return (float)str_replace('.', '', $inputPrice);
    }

    public function sendEmails(Collection $notifications): void
    {
        $notifications->each(function (PriceNotification $notification) {
            Mail::to($notification->email)->queue(new NotificationsExceedingPrice($notification));
        });
    }
}