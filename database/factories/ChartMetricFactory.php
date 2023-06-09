<?php

namespace Database\Factories;

use App\Models\ChartMetric;
use App\Models\CryptoSymbol;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartMetricFactory extends Factory
{
    protected $model = ChartMetric::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(),
            'crypto_symbol_id' => 1,
            'created_at' => Carbon::now(),
        ];
    }

    public function withPrice(float $price): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'price' => $price,
            ],
        );
    }

    public function withCryptoSymbol(CryptoSymbol $symbol): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'crypto_symbol_id' => $symbol->id,
            ],
        );
    }

    public function withCreatedAt(Carbon $createdAt): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'created_at' => $createdAt,
            ],
        );
    }
}
