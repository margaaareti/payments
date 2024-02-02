<?php

namespace App\Services\Tinkoff\Actions;

use App\Services\Tinkoff\Entities\PaymentEntity;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\TinkoffService;
use Illuminate\Support\Facades\Http;
use TheSeer\Tokenizer\Token;

class CreatePaymentAction
{

    public function __construct(private TinkoffService $tinkoff)
    {

    }

    public static function make(TinkoffService $tinkoff): static
    {
        return new static($tinkoff);
    }

    public function run(CreatePaymentData $data): PaymentEntity
    {
        $data = [
            'Amount' => $data->amount,
            'OrderId' => $data->order,
            'Password' => $this->tinkoff->config->password,
            'TerminalKey' => $this->tinkoff->config->terminal,
        ];

        $values = implode('', array_values($data));

        $data['Token']=hash('sha256', $values);

        $response = Http::post('https://securepay.tinkoff.ru/v2/Init', $data);


        $response = $response->json();

        return new PaymentEntity(
            id: $response['PaymentId'],
            status: PaymentStatusEnum::from($response['Status']),
            order: $response['OrderId'],
            amount: $response['amount'],
            url: $response['paymentURL'],
        );
    }
}
