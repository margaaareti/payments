@extends('layouts.main')

@section('main.content')

    <section>

        <div class="container">

            <h4 class="mb3">Мои подписки</h4>


            <div class="card">

                <div class="card-body">
                    <h5 class="card-title m-0">
                        Детали подписки
                    </h5>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4 text-muted">
                                ID подписки
                            </div>
                            <div class="col-8">
                                {{$subscription->uuid}}
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4 text-muted">
                                Стоимость подписки
                            </div>
                            <div class="col-8">
                                {{$subscription->price}} {{$subscription->currency_id}}
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4 text-muted">
                                Статус подписки
                            </div>
                            <div class="col-8">
                                <div class="text-{{$subscription->status->color()}}">{{$subscription->status->name()}}</div>
                            </div>
                        </div>
                    </li>
                </ul>

                @if($subscription->status->isPending())
                    <div class="card-body">
                        <form action="{{route('subscriptions.payment', $subscription->uuid)}}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-primary">
                                Перейти к оплате
                            </button>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </section>

@endsection
