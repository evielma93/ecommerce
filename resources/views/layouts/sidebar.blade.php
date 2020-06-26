@inject('cart', 'App\Classes\Cart')
<div class="container-fluid">
    <div class="row justify-content-center">

      <table class="table table-bordered table-sm shadow">
        <thead class="thead-dark text-center">
            <tr>
                <th scope="col">{{ __("Producto") }}</th>
                <th scope="col">{{ __("Cantidad") }}</th>
                <th scope="col">{{ __("Total") }}</th>
                <th scope="col">{{ __("Acciones") }}</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse($cart->getContent() as $product)
            <tr>
                <td class="text-left">{{ $product->products->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $cart->totalAmountForProduct($product) }}</td>
                <td>
                    <form method="POST" action="{{ route('product.delete', ["id" => $product->id]) }}">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    <p class="alert alert-warning text-center">
                        {{ __("No hay productos en el carrito!") }}
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($cart->hasProducts())
        <tfoot>
            <tr>
                <td colspan="3">
                    {{ __("Impuestos") }}
                </td>
                <td class="text-center">
                    {{ $cart->taxes() }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {{ __("Coste total") }}
                </td>
                <td class="text-center">
                    {{ $cart->totalAmount() }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {{ __("Coste total con impuestos") }}
                </td>
                <td class="text-center">
                    {{ $cart->totalAmountWithTaxes() }}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    @guest
                    <a href="{{ route('login') }}">{{ __("Inicia sesión para realizar el pedido") }}</a>
                    @else
                    <form method="POST" action="{{ route('orders.process') }}">
                        @csrf
                        <button type="submit" class="btn-block alert alert-success">
                            <i class="fa fa-credit-card"></i> {{ __("Procesar carrito") }}
                        </button>
                    </form>
                    @endguest
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
</div>