<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PriceNotification;
use Illuminate\Database\Eloquent\Builder;

class PriceNotificationRepository
{
    public function updateOrCreate($attributes, $values): PriceNotification
    {
        return PriceNotification::updateOrCreate($attributes, $values);
    }

    public function getNotificationsExceedingPriceQuery(float $lastPrice): Builder
    {
        return PriceNotification::query()
            ->where('price_limit', '<', $lastPrice);
    }
}