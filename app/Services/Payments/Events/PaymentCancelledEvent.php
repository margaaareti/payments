<?php

namespace App\Services\Payments\Events;

class PaymentCancelledEvent
{
    public PaymentCancelledData $data;

    public function __construct(PaymentCancelledData $data)
    {
        $this->data = $data;

    }

}
