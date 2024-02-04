<?php

namespace App\Services\Tinkoff;


use App\Services\Tinkoff\Actions\CancelPaymentAction;
use App\Services\Tinkoff\Actions\CheckCallbackAction;
use App\Services\Tinkoff\Actions\CreatePaymentAction;
use App\Services\Tinkoff\Actions\CreatePaymentData;
use App\Services\Tinkoff\Actions\FindPaymentAction;
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

    public function findPayment(string $paymentId):PaymentEntity
    {
        return FindPaymentAction::make($this)->run($paymentId);
    }

    public function cancelPayment(string $paymentId):PaymentEntity
    {
        return CancelPaymentAction::make($this)->run($paymentId);
    }


    public function checkCallback(array $data):PaymentEntity
    {
        return CheckCallbackAction::make($this)->run($data);
    }

}
