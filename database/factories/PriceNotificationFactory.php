<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PriceNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceNotificationFactory extends Factory
{
    protected $model = PriceNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'price_limit' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    public function withEmail(string $email): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'email' => $email,
            ],
        );
    }

    public function withPriceLimit(float $priceLimit): static
    {
        return $this->state(
            fn(array $attributes): array => [
                'price_limit' => $priceLimit,
            ],
        );
    }
}
