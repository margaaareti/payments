<?php

namespace App\Services\Payments;

use App\Services\Payments\Actions\CancelPaymentAction;
use App\Services\Payments\Actions\CompletePaymentAction;
use App\Services\Payments\Actions\CreatePaymentAction;
use App\Services\Payments\Actions\GetPaymentMethodAction;
use App\Services\Payments\Actions\GetPaymentsAction;
use App\Services\Payments\Actions\UpdatePaymentAction;
use App\Services\Payments\Drivers\PaymentDriver;
use App\Services\Payments\Drivers\PaymentDriverFactory;
use App\Services\Payments\Enums\PaymentDriverEnum;

class PaymentService

{
    public function getDriver(PaymentDriverEnum $driver): PaymentDriver
    {

        return (new PaymentDriverFactory)->make($driver);

    }

    public function createPayment(): CreatePaymentAction
    {

        return new CreatePaymentAction;

    }

    public function getPayments(): GetPaymentsAction
    {

        return new GetPaymentsAction;

    }


    public function updatePaymentAction(): UpdatePaymentAction
    {

        return new UpdatePaymentAction();

    }

    public function getPaymentMethods(): GetPaymentMethodAction
    {

        return new GetPaymentMethodAction();

    }

    public function completePayment(): CompletePaymentAction
    {

        return new CompletePaymentAction();

    }

    public function cancelPayment(): CancelPaymentAction
    {
        return new CancelPaymentAction();

    }

}
