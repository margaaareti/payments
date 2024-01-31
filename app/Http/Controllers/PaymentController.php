<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePaymentRequest;
use App\Services\Payments\Models\Payment;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PaymentController extends Controller
{

    public function checkout(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);

        //Получение методов оплаты
        $methods = $paymentService
            ->getPaymentMethods()
            ->active(true)
            ->get();

        return view('payments.checkout', compact('payment', 'methods'));
    }


    public function method(UpdatePaymentRequest $request, Payment $payment, PaymentService $paymentService)
    {

        abort_unless($payment->status->isPending(), 404);

        $validated = $request->validated();

        $method = $paymentService
            ->getPaymentMethods()
            ->id($validated['method_id'])
            ->active()
            ->first();

        abort_unless($method, 404);

        $paymentService
            ->updatePaymentAction()
            ->method($method)
            ->run($payment);

        return redirect()->route('payments.process', $payment->uuid);
    }


    public function process(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->method_id, 404);

        $driver = $paymentService->getDriver($payment->driver);

//        return view("payments.drivers.{$payment->driver->value}", compact('payment'));
//        return view("payments::{$payment->driver->value}", compact('payment'));
          return $driver->view($payment);

    }

    public function complete(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->driver->isTest(), 404);
        abort_if(app()->isProduction(), 404);

        $paymentService->completePayment()->run($payment);

        return redirect()->route('payments.success', [
            'uuid' => $payment->uuid,
        ]);

    }

    public function cancel(Payment $payment, PaymentService $paymentService)
    {
        abort_unless($payment->status->isPending(), 404);
        abort_unless($payment->driver->isTest(), 404);
        abort_if(app()->isProduction(), 404);

        $paymentService->cancelPayment()->run($payment);

        return redirect()->route('payments.failure', [
            'uuid' => $payment->uuid,
        ]);

    }

    public function success(Request $request, Payment $payment, PaymentService $paymentService)
    {

        $uuid = $request->input('uuid');

        abort_unless(Str::isUuid($uuid), 404);

        $payment = $paymentService
            ->getPayments()
            ->setUuid($uuid)
            ->first();

        abort_unless($payment, 404);


        return view('payments.success', compact('payment'));

    }

    public function failure(Request $request, Payment $payment, PaymentService $paymentService)
    {

        $uuid = $request->input('uuid');

        abort_unless(Str::isUuid($uuid), 404);

        $payment = $paymentService
            ->getPayments()
            ->setUuid($uuid)
            ->first();

        return view('payments.failure', compact('payment'));

    }

}


