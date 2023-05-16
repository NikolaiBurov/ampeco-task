<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\DTO\ChartDataDTO;

class Serializer
{
    public function deserializeToDTO(string $data): ChartDataDTO
    {
        return new ChartDataDTO(json_decode($data, true));
    }
}