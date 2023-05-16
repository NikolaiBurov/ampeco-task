<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\CryptoSymbol;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CryptoSymbolsRepository
{
    public function findSymbolByName(string $name): CryptoSymbol|Model
    {
        return CryptoSymbol::query()
            ->where('name', '=', $name)
            ->first();
    }
}