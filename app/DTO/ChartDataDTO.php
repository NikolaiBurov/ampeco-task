<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\Carbon;

class ChartDataDTO
{
    public function __construct(public array $data)
    {
    }

    public function getPrice(): float
    {
        return (float)$this->data['last_price'];
    }

    public function getCreatedAt(): Carbon
    {
        return Carbon::now();
    }
}