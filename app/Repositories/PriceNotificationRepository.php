<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PriceNotification;

class PriceNotificationRepository
{
    public function updateOrCreate($attributes, $values): PriceNotification
    {
        return PriceNotification::updateOrCreate($attributes, $values);
    }
}