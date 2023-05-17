<?php

namespace Database\Seeders;

use App\Models\ChartMetric;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChartMetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        ChartMetric::create([
            'price' => 24000.000,
            'created_at' => $date,
            'crypto_symbol_id' => 1
        ]);

        ChartMetric::create([
            'price' => 22000.000,
            'created_at' => $date->addMinute(),
            'crypto_symbol_id' => 1
        ]);

        ChartMetric::create([
            'price' => 23000.000,
            'created_at' => $date->addMinutes(2),
            'crypto_symbol_id' => 1
        ]);

        ChartMetric::create([
            'price' => 25000.000,
            'created_at' => $date->addMinutes(3),
            'crypto_symbol_id' => 1
        ]);
    }
}
