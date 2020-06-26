@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <table class="table">
                <thead class="thead-dark text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __("Precio") }}</th>
                    <th scope="col">{{ __("Procesado") }}</th>
                    <th scope="col">{{ __("Factura") }}</th>
                    <th scope="col">{{ __("Detalle") }}</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->formatted_total_amount }}</td>
                        <td>
                                <span class="badge badge-pill badge-{{ $order->formatted_status === __("Procesado") ? "success" : "danger" }}">
                                    {{ $order->formatted_status }}
                                </span>
                        </td>
                        <td>
                            @if($order->invoice_id)
                                <a href="{{ route("orders.invoice", ["invoice" => $order->invoice_id]) }}">
                                    {{ __("Descargar factura") }}
                                </a>
                            @else
                                <form method="POST" action="{{ route('orders.to_cart', ['id' => $order->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-shopping-cart"></i> {{ __("Volcar pedido en carrito") }}
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('orders.detail', ["id" => $order->id]) }}">
                                {{ __("Ver detalle") }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4">
                            <p class="alert alert-info">
                                {{ __("No hay pedidos en tu cuenta todavía") }}
                            </p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="row justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection