<?php

namespace App\Services\Orders\Models;

use App\Services\Orders\Enums\OrderStatusEnum;
use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Support\Values\AmountValue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property PaymentDriverEnum $status
 * @property AmountValue $amount
 * @property string $currency_id
 */

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'currency_id', 'amount',
    ];


    protected $casts = [
        'status' => OrderStatusEnum::class,
        'amount' => AmountValue::class,
    ];
}
