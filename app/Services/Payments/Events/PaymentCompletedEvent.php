<?php

namespace App\Services\Payments\Events;

class PaymentCompletedEvent
{
    public PaymentCompletedData $data;

    public function __construct(PaymentCompletedData $data)
    {
        $this->data = $data;

    }

}
