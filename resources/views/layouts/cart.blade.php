@extends('layouts.plantilla')

@section('content')
@inject('cart', 'App\Classes\Cart')
<div class="container">
	<div class="mb-10"></div>
	<h2 class="mb-4">Resumen del Pedido</h2>
	<div class="card">
		<form action="{{ route('pay') }}" method="POST" id="paymentForm" name="paymentForm">
			@csrf
			<table class="table table-hover shopping-cart-wrap">
				<thead class="text-muted">
					<tr>
						<th scope="col">{{ __("Producto") }}</th>
						<th scope="col" style="width: 5px;">{{ __("Cantidad") }}(Lb)</th>
						<th scope="col">{{ __("Precio Unt. $") }}</th>
						<th scope="col">{{ __("Total. $") }}</th>
						<th scope="col">{{ __("Acciones") }}</th>
					</tr>
				</thead>
				<tbody>
					@php $cont = 0; @endphp
					@forelse($cart->getContent() as $product)
					@php $cont++; @endphp
					<tr>
						<td>
							<figure class="media">
								<figcaption class="media-body">
									<div class="card-title small mb-0">{{ $product->products->name }}</div>
									<input type="text" value="{{$product->id}}" hidden name="id_produc[]">
								</figcaption>
							</figure>
						</td>
						<td>
							<div class="product-quantity2">
								<input type="number" id="cant{{$cont}}" onchange="calcular(this.value,{{$cont}})" class="form-control" min="1" name="cant[]" value="{{ $product->quantity }}">
							</div>
						</td>
						<td>
							<div class="price-wrap">
								<var class="price card-title small mb-0 product-price">
									<input type="text" readonly class="form-control-plaintext" value="{{ $cart->priceForProducts($product) }}" name="vunit[]" id="vunit{{$cont}}">
								</var>
							</div> <!-- price-wrap .// -->
						</td>
						<td>
							<div class="price-wrap">
								<var class="price card-title small mb-0">
									<span class="vtotal" id="vtotal{{$cont}}"></span>
									<input type="text" hidden required name="vtotal[]" id="vtotal2{{$cont}}">
								</var>
							</div> <!-- price-wrap .// -->
						</td>
						<td>
							<button class="btn btn-danger eliminar" value="{{$product->id}}">
								<i class="fa fa-trash"></i>
							</button>

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
				@if($users)
				@php $envio = $users->sectors->shipping_price ?? null @endphp
				@php $sector = $users->sectors->name ?? null @endphp
				@else
				@php $envio = 0 @endphp
				@php $sector = 'Debe Iniciar Sesión' @endphp
				@endif
				@if($cart->hasProducts())

				<tfoot>
					<tr>
						<td colspan="4">
							<div class="card-title small mb-0">Envío {{ $sector }}</div>
						</td>
						<td class="text-center">
							<div class="card-title small mb-0">&#36;{{ $envio }}</div>
							<input type="text" hidden id="detalleEnvio" name="detalleEnvio"  value="{{ $envio }}">
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="card-title small mb-0">{{ __("Coste total") }}</div>
						</td>
						<td class="text-center">
							<div id="subto" class="card-title small mb-0">&#36;{{ $cart->totalAmount() }}</div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="card-title small mb-0">{{ __("Coste total con envío") }}</div>
						</td>
						<td class="text-center">
							<div id="total" class="card-title small mb-0">&#36;{{ $cart->totalAmountWithDelivery($envio) }}</div>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="card-title small mb-0">Código de Vendedor</div>
						</td>
						<td class="text-center">
							<input type="text" class="form-control" id="code_seller" name="code_seller">
						</td>
					</tr>
					<tr>
						<td colspan="5">
							@guest
							<a href="{{ route('login') }}">{{ __("Inicia sesión para realizar el pedido") }}</a>
							@else
							<!--<form method="POST" action="{{-- route('orders.process') --}}"> -->

								<input	type="text" name="value" hidden id ="valueTot"	required >
								<input type="text" id="currency" hidden name="currency" value="USD">
								<div class="row mt-3">
									<div class="col">
										<label>
										Seleccione la plataforma de pago deseada:</label>
										<div class="form-group" id="toggler">
											<div class="btn-group btn-group-toggle" data-toggle="buttons">
												@foreach ($paymentPlatforms as $paymentPlatform)
												<label
												class="btn btn-outline-secondary rounded m-2 p-1"
												data-target="#{{ $paymentPlatform->name }}Collapse"
												data-toggle="collapse"
												>
												<input type="radio" name="payment_platform" value="{{ $paymentPlatform->id }}"	required >
												<img class="img-thumbnail" src="{{ asset($paymentPlatform->image) }}">
											</label>
											@endforeach
										</div>
										@foreach ($paymentPlatforms as $paymentPlatform)
										<div
										id="{{ $paymentPlatform->name }}Collapse"
										class="collapse"
										data-parent="#toggler"
										>
										@includeIf('components.' . strtolower($paymentPlatform->name) . '-collapse')
									</div>
									@endforeach
								</div>
							</div>
						</div>
						@if(!$users)
						<a href="{{ route('registerCli') }}">{{ __("Registra tus datos para el envío y facturación") }}</a>
						@else
						<button type="submit" id="payButton" class="btn-block alert alert-success">
							<i class="fa fa-credit-card"></i> {{ __("Procesar carrito") }}
						</button>
						@endif

					</form>

					@endguest
				</td>
			</tr>
		</tfoot>
		@endif
	</table>
</div> <!-- card.// -->
</div>
<div class="mb-10"></div>
@endsection

@section('scripts')
<script src="js/cart.js"></script>
@endsection