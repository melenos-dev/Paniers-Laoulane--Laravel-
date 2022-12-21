@extends('layouts.app')   
	@section('title'){{ $category->name }} | Les paniers de Laoul'ane !@stop

	@section('meta')
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ asset('img/logo/logo.png')}}">
	@stop

	@section('ariane')
		<div class="ariane">
			<a href="{{ route('welcome') }}">@lang('Home')</span></a>
			@foreach ($ariane as $cat)
				@php
					echo $cat
				@endphp
			@endforeach
        </div>

		@if(session()->has('ok'))
			<script type="text/javascript">
				$(function() {
					$('.collapse').collapse();
				});
			</script>
			
			<div class="alert alert-success alert-dismissible collapse mb-0">
				{!! session('ok') !!}
			</div>
        @endif
	@stop

	@section('middle')
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

		<h2 class="mt-2">@lang('Products in category') {{ $category->name }}</h2>
		<div class="d-flex flex-wrap mt-1">
			@if($products = $query)
				@foreach($products as $product)
					<article class="article-small">
						<a href="{{ route('product.index', array($product->id, $product->productCat->slug, $product->slug)) }}">
							<header>
								<img src="{{ asset('uploads/products/'.$product->img.'')}}" alt="{{ $product->product_name }}"/>
								<p>{{\Illuminate\Support\Str::limit($product->description, 70, '...')}}</p>
							</header>
							
							<section class="d-flex justify-content-between">
								<div class="left">
									<h3 title="{{$product->product_name}}">{{$product->product_name}}</h3>
								</div>
								
								@if($product->product_price != '')
									<span class="price"><b>{{$product->priceRender()}} €</b></span>
								@else
										<span class="price"><b>{{$product->product_total_price}} €</b></span>
								@endif
							</section>
						</a>
					</article>
				@endforeach
			@endif
		</div>
		@if($query->count() == 0)
				<p class="alert alert-danger mb-0">@lang('No product registered in this category.')</p>
		@else
			{!! $query->render() !!}
		@endif
    @stop