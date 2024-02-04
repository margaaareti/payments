<?php

namespace App\Services\Tinkoff;

use App\Services\Tinkoff\Exceptions\TinkoffException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TinkoffClient
{


    public function __construct(public TinkoffService $tinkoff)
    {
    }

    public static function make(TinkoffService $tinkoff): static
    {
        return new static($tinkoff);
    }

    public function post(string $url, array $data):array
    {

        $data = $this->addToken($data);

        $response = $this->client()->post($url, $data);

        $response = $response->json();

        if ($response['Success'] === false) {
            throw new TinkoffException($response['Details']);
        }

        return $response;
    }

    public function client():PendingRequest
    {

        return Http::baseUrl('https://securepay.tinkoff.ru/v2/');
    }

    public function addToken(array $data): array
    {
        unset($data['Token']);

        if(isset($data['Success'])) {
            $data['Success']=$data['Success'] ? 'true' : 'false';
        }

        $token = collect($data)->sortKeys()->implode('');
        $token = hash('sha256', $token);
        $data['Token'] = $token;

        return $data;

    }
}
