<?php

namespace App\Services\Payments\Events;

use App\Services\Payments\Models\Payment;

class PaymentCancelledData
{
    public string $uuid;
    public string $payableType;
    public string $payableId;

    public function __construct(Payment $payment)
    {
        $this->uuid=$payment->uuid;
        $this->payableType=$payment->payable_type;
        $this->payableId=$payment->payable_id;
    }

//    public static function fromPayment(Payment $payment): static
//    {
//        return new static(uuid: $payment->uuid);
//    }
}
