<?php

namespace App\Services\Payments\Drivers;

use App\Services\Payments\Enums\PaymentDriverEnum;
use InvalidArgumentException;

class PaymentDriverFactory

{
    public function make(PaymentDriverEnum $driver):PaymentDriver
    {
        return match ($driver) {
            PaymentDriverEnum::test => new TestPaymentDriver(),
            PaymentDriverEnum::tinkoff => new TinkoffDriver(),

            default =>  throw new InvalidArgumentException(
                "Драйвер [{$driver->name()}] не поддерживается",
            )
        };
    }

}
