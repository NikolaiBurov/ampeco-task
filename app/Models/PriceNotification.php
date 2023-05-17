<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PriceNotification
 * @property int $id
 * @property string $email
 * @property float $price_limit
 * @property Carbon $created_at
 * @property Carbon $updated_at
 **/
class PriceNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'price_limit'
    ];
}
