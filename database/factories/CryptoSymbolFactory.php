<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CryptoSymbol;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CryptoSymbolFactory extends Factory
{
    protected $model = CryptoSymbol::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => CryptoSymbol::BTCN_SYMBOL,
            'created_at' => Carbon::now(),
        ];
    }

    public function withName(string $name): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'name' => $name,
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
