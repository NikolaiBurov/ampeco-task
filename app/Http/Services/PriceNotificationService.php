<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\PriceNotification;
use App\Repositories\PriceNotificationRepository;

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
}