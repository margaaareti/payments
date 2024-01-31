<?php

namespace App\Services\Orders\Listeners;

use App\Services\Orders\Models\Order;
use App\Services\Orders\OrderService;
use App\Services\Payments\Events\PaymentCancelledEvent;
use Exception;

class CancelOrderListener
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(PaymentCancelledEvent $event): void
    {
        $payableType = $event->data->payableType;
        $payableId = $event->data->payableId;

        if ($payableType !== (new Order)->getPayableType()) {
            return;
        }

        if ($order = Order::query()->find($payableId)) {
           $this->orderService->cancelOrder()->run($order);
        } else {
            throw new Exception();
        }

    }
}
