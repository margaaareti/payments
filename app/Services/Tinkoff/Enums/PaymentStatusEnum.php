<?php

namespace App\Services\Tinkoff\Enums;

enum PaymentStatusEnum: string
{
    case NEW = 'NEW';
    case CANCELED = 'CANCELED';
    case REVERSED = 'REVERSED';
    case REFUNDED = 'REFUNDED';
    case CONFIRMED = 'CONFIRMED';
    case AUTHORIZED = 'AUTHORIZED';
    case REJECTED = 'REJECTED';
}
