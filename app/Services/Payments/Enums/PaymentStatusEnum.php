<?php

namespace App\Services\Payments\Enums;

enum PaymentStatusEnum: string
{
    case pending = 'pending';
    case completed = 'completed';
    case cancelled = 'cancelled';


    public function name(): string
    {
        return match ($this) {
            self::pending=> 'Ожидает оплаты',
            self::completed=> 'Оплачен',
            self::cancelled=> 'Отменен',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending=> 'warning',
            self::completed=> 'success',
            self::cancelled=> 'danger',
        };
    }
}
