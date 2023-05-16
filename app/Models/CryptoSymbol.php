<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CryptoSymbol
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 **/
class CryptoSymbol extends Model
{
    use HasFactory;

    public const BTCN_SYMBOL = 'BTCUSD';

    protected $fillable = [
        'name'
    ];
}
