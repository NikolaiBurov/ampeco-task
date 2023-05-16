<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class ChartMetric
 * @property int $id
 * @property int $price
 * @property int $crypto_symbol_id
 * @property Carbon $created_at
 **/
class ChartMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'crypto_symbol_id',
        'created_at',
    ];

    public $timestamps = false;

    public function cryptoSymbol(): Relation
    {
        return $this->belongsTo(CryptoSymbol::class);
    }
}
