<?php

namespace App\Services\Payments\Drivers;

use App\Services\Payments\Models\Payment;
use App\Services\Tinkoff\Actions\CreatePaymentData;
use App\Services\Tinkoff\TinkoffConfig;
use App\Services\Tinkoff\TinkoffService;
use Illuminate\Contracts\View\View;

class TinkoffDriver extends PaymentDriver

{
    public function view(Payment $payment): View
    {
        $config = config('services.tinkoff');

        $tinkoffService = new TinkoffService(
            new TinkoffConfig(
                terminal: $config['terminal'],
                password: $config['password'],
            )
        );

        $entity = $tinkoffService->createPayment(
            new CreatePaymentData(
                amount: $payment->amount->value() * 100,
                order: $payment->uuid,
                successUrl: route('payments.success', ['uuid'=>$payment->uuid]),
                failureUrl: route('payments.failure', ['uuid'=>$payment->uuid]),
                callbackUrl:'https://dddwww.free.beeceptor.com',
            )
        );

        $payment->update(['driver_payment_id'=> $entity->id]);


        return view('payments::tinkoff', compact('entity'));
    }
}
