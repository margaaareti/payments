<?php

namespace App\Services\Tinkoff\Actions;

use App\Services\Tinkoff\Entities\PaymentEntity;
use App\Services\Tinkoff\Enums\PaymentStatusEnum;
use App\Services\Tinkoff\Exceptions\TinkoffException;
use App\Services\Tinkoff\TinkoffClient;
use App\Services\Tinkoff\TinkoffService;
use Exception;
use Illuminate\Support\Facades\Http;

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

        $myToken = TinkoffClient::make($this->tinkoff)
            ->addToken($data);

        //Формируем свой токен для проверки
        if ($data['Token'] !== $myToken['Token']) {
            throw new TinkoffException('Неверный токен');
        }

        return new PaymentEntity(
            id: $data['PaymentId'],
            status: PaymentStatusEnum::from($data['Status']),
            order: $data['OrderId'],
            amount: $data['Amount'],
        );
    }
}
