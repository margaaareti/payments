<?php

namespace App\Services\Tinkoff\Actions;

use App\Services\Tinkoff\Entities\PaymentEntity;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\Exceptions\TinkoffException;
use App\Services\Tinkoff\TinkoffClient;
use App\Services\Tinkoff\TinkoffService;
use Exception;

class CheckCallbackAction
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
    public function run(array $data): PaymentEntity
    {

        $token = TinkoffClient::make($this->tinkoff)
            ->createToken($data);


        //Формируем свой токен для проверки
        if ($data['Token'] !== $token) {
            throw new TinkoffException('Неверный токен: ' . $token . ', ожидался: ' . $token);
        }

        return new PaymentEntity(
            id: $data['PaymentId'],
            status: PaymentStatusEnum::from($data['Status']),
            order: $data['OrderId'],
            amount: $data['Amount'],
        );
    }
}
