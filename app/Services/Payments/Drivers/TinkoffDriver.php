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

        $tinkoffService->createPayment(
            new CreatePaymentData(
                amount: $payment->amount->value() * 100,
                order: $payment->uuid,
                successUrl: route('payments.success', ['uuid'=>$payment]),
                failureUrl: route('payments.failure', ['uuid'=>$payment]),
                callbackUrl:'https://webhook.site/d60efa34-6cf9-41f9-975c-aaff3069b94f',
            )
        );

        return view('payments::tinkoff', compact('payment'));
    }
}
