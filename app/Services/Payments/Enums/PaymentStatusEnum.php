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
            self::pending => 'Ожидает оплаты',
            self::completed => 'Оплачен',
            self::cancelled => 'Отменен',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending => 'warning',
            self::completed => 'success',
            self::cancelled => 'danger',
        };
    }

    public function is(PaymentStatusEnum $status): bool
    {
        return $this === $status;

    }

    public function isPending(): bool
    {
        return $this->is(PaymentStatusEnum::pending);

    }

    public function isCompleted(): bool
    {
        return $this->is(PaymentStatusEnum::completed);

    }

    public function isCanceled(): bool
    {
        return $this->is(PaymentStatusEnum::cancelled);

    }

}
