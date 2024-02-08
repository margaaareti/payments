<?php

namespace App\Http\Controllers\Api\Payments\Callbacks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentService;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\Exceptions\TinkoffException;
use App\Services\Tinkoff\TinkoffConfig;
use App\Services\Tinkoff\TinkoffService;
use Illuminate\Http\Request;


class TinkoffController extends Controller
{
    /**
     * @throws TinkoffException
     */
    public function __invoke(Request $request, PaymentService $paymentService)
    {

        $config = config('services.tinkoff');

        $tinkoffService = new TinkoffService(
            new TinkoffConfig(
                terminal: $config['terminal'],
                password: $config['password'],
            )
        );

        try {
            $entity = $tinkoffService->checkCallback($request->all());

            //Получение платежа из нашей БД
            $payment = $paymentService->getPayments()->setUuid($entity->order)->first();

            match ($entity->status) {
                PaymentStatusEnum::CONFIRMED => $paymentService->completePayment()->run($payment),
                PaymentStatusEnum::REJECTED, PaymentStatusEnum::REFUNDED, PaymentStatusEnum::REVERSED, PaymentStatusEnum::CANCELED => $paymentService->cancelPayment()->run($payment),
                default => null,
            };

        } catch (TinkoffException $e) {
            report($e);
        }

        return response('OK', 200);

    }
}
