<?php

namespace App\Services\Tinkoff;


use App\Services\Tinkoff\Actions\CreatePaymentAction;
use App\Services\Tinkoff\Actions\CreatePaymentData;
use App\Services\Tinkoff\Entities\PaymentEntity;

class TinkoffService
{
    public function __construct(public TinkoffConfig $config)
    {
    }


    public function createPayment(CreatePaymentData $data): PaymentEntity
    {
        return CreatePaymentAction::make($this)->run($data);
        //return (new CreatePaymentAction($this))->run($data);
    }
}
