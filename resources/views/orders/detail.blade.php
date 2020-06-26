@extends('layouts.plantilla')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h1 class="text-center text-muted">{{ __("Información del pedido") }}</h1>
            <table class="table table-striped">
                <thead class="text-center">
                <tr>
                    <th scope="col">{{ __("ID Pedido") }}</th>
                    <th scope="col">{{ __("Precio con impuestos") }}</th>
                    <th scope="col">{{ __("Procesado") }}</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <th scope="col">{{ $order->formatted_total_amount }}</th>
                    <th scope="col">
                        <span class="badge badge-pill badge-{{ $order->formatted_status === __("Procesado") ? "success" : "danger" }}">
                            {{ $order->formatted_status }}
                        </span>
                    </th>
                </tr>
                </tbody>
            </table>

            <h2 class="text-center text-muted">{{ __("Líneas del pedido") }}</h2>
            <table class="table table-striped">
                <thead class="text-center">
                <tr>
                    <th scope="col">{{ __("Curso") }}</th>
                    <th scope="col">{{ __("Precio sin impuestos") }}</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($order->orderLines as $orderLine)
                    <tr>
                        <th scope="row">
                            <a href="{{ route('course.start', ["id" => $orderLine->product->id]) }}">
                                {{ __("Empezar el curso :course", ["course" => $orderLine->product->name]) }}
                            </a>
                        </th>
                        <th scope="col">{{ format_currency_helper($orderLine->product->price) }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection