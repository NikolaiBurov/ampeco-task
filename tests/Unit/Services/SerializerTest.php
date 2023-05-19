<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTO\ChartDataDTO;
use App\Services\Serializer;
use Carbon\Carbon;
use Tests\TestCase;

class SerializerTest extends TestCase
{
    public function test_if_serializer_deserializes_json_to_dto(): void
    {
        $serializer = new Serializer();

        $data = '{"last_price": 10.99}';

        $dto = $serializer->deserializeToDTO($data);

        $this->assertInstanceOf(ChartDataDTO::class, $dto);
        $this->assertInstanceOf(Carbon::class, $dto->getCreatedAt());
        $this->assertEquals(10.99, $dto->getPrice());
    }
}