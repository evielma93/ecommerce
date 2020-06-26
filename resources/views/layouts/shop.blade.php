@extends('layouts.plantilla')

@section('content')
<div class="container"> <br>
	<h2 class="mb-6">Nuestros Productos</h2>
	<div class="row">
		@forelse($products as $product)
		<div class="col-xl-3 col-lg-4 col-md-6 mb-5">
			<div class="card lift h-100 " href="#!">
				<div class="card-flag card-flag-dark card-flag-top-left card-flag-lg">
					${{ $product->sale_price }}
				</div>
				<img class="card-img-top" src="{{route('products.image',['filename' => $product->products->image_path]) }}" alt="..." />
				<div class="card-body p-3">
					<div class="card-title small mb-0">{{ $product->products->name }}</div>
					<div class="text-xs text-gray-500">{{ $product->products->description }}</div>
				</div>
				<div class="card-footer">
					@if(!in_array($product->id, $coursesPurchased))
					<form action="{{ route('product.add', ["id" => $product->id]) }}" method="POST">
						@csrf
						<button type="submit" class="btn btn-gold float-right">
							<i class="fa fa-cart-plus"></i> {{ __("Añadir") }}
						</button>
					</form>
					@else
					<a href="{{ route('course.start', ["id" => $product->id]) }}" class="btn btn-dark">
						<i class="fa fa-check-circle"></i> {{ __("Ya has comprado este articulo") }}
					</a>
					@endif
				</div>
			</div>
		</div>
		@empty
		<div class="alert alert-info text-center">No hay productos disponibles</div>
		@endforelse
	</div>


	<div class="mb-10">
		<a hidden class="text-arrow-icon" href="#!">See more deals near you<i data-feather="arrow-right"></i></a>
	</div>


	<h2 hidden class="mb-4">Browse Categories</h2>
	<div class="row" hidden>
		<div class="col-lg-3 col-md-6 mb-5">
			<a class="card lift border-bottom-lg border-red" href="#!"
			><div class="card-body text-center">
				<div class="icon-stack icon-stack-xl bg-red text-white mb-2"><i class="fas fa-car"></i></div>
				<div class="small text-gray-600">Cars</div>
			</div></a
			>
		</div>
		<div class="col-lg-3 col-md-6 mb-5">
			<a class="card lift border-bottom-lg border-orange" href="#!"
			><div class="card-body text-center">
				<div class="icon-stack icon-stack-xl bg-orange text-white mb-2"><i class="fas fa-home"></i></div>
				<div class="small text-gray-600">Housing</div>
			</div></a
			>
		</div>
	</div>
</div>
@endsection