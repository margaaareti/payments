<?php

namespace App\Services\Tinkoff\Actions;

use App\Services\Tinkoff\Entities\PaymentEntity;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\TinkoffClient;
use App\Services\Tinkoff\TinkoffService;
use Exception;

class CreatePaymentAction
{

    public function __construct(private readonly TinkoffService $tinkoff)
    {

    }

    public static function make(TinkoffService $tinkoff): static
    {
        return new static($tinkoff);
    }

    /**
     * @throws Exception
     */
    public function run(CreatePaymentData $data): PaymentEntity
    {
        $data = [
            'Amount' => $data->amount,
            'OrderId' => $data->order,
            'Password' => $this->tinkoff->config->password,
            'TerminalKey' => $this->tinkoff->config->terminal,
            'SuccessURL'=>$data->successUrl,
            'FailURL'=>$data->failureUrl,
            'NotificationURL'=>$data->callbackUrl,
        ];

        $response = TinkoffClient::make($this->tinkoff)->post('Init', $data);

        return new PaymentEntity(
            id: $response['PaymentId'],
            status: PaymentStatusEnum::from($response['Status']),
            order: $response['OrderId'],
            amount: $response['Amount'],
            url: $response['PaymentURL'],
        );
    }
}
