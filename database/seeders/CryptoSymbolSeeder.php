<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CryptoSymbol;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoSymbolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->hasBtcSymbol() === false) {
            DB::table('crypto_symbols')->insert([
                'name' => CryptoSymbol::BTCN_SYMBOL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }

    private function hasBtcSymbol(): bool
    {
        return DB::table('crypto_symbols')->where('name', '=', CryptoSymbol::BTCN_SYMBOL)->exists();
    }
}
