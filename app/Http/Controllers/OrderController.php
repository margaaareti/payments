<?php

namespace App\Http\Controllers;

use App\Services\Orders\Models\Order;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::query()->get();


        return view('orders.index', compact('orders'));
    }


    public function show(Order $order, Request $request)
    {
//        $user = $request->user();
//
//        abort_unless($user->owns($order),404);

        return view('orders.show', compact('order'));

    }

    public function payment(Order $order, PaymentService $paymentService)
    {
        $payment = $paymentService
            ->createPayment()
            ->payable($order)
            ->run();

        return to_route('payments.checkout',['payment'=> $payment->uuid]);

    }
}
