<?php

namespace App\Services\Tinkoff\Actions;

use App\Services\Tinkoff\Entities\PaymentEntity;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\Exceptions\TinkoffException;
use App\Services\Tinkoff\TinkoffClient;
use App\Services\Tinkoff\TinkoffService;
use Exception;
use Illuminate\Support\Facades\Http;

class CancelPaymentAction
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
    public function run(string $id): PaymentEntity
    {

        $data = [
            'PaymentId' => $id,
            'Password' => $this->tinkoff->config->password,
            'TerminalKey' => $this->tinkoff->config->terminal,
        ];

        $response = TinkoffClient::make($this->tinkoff)->post('Cancel', $data);

        return new PaymentEntity(
            id: $response['PaymentId'],
            status: PaymentStatusEnum::from($response['Status']),
            order: $response['OrderId'],
            amount: $response['NewAmount'],
        );
    }
}
