@extends('layouts.app')   
	@section('title')Les paniers de Laoul'ane ! @lang('Local producers in Morbihan, Brittany')@stop

	@section('meta')
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ asset('img/nos_produits_locaux_morbihan.jpg')}}">
		@stop

	@section('middle')
		@if(session()->has('ok'))
			<script type="text/javascript">
				$(function() {
					$('.alert.collapse').collapse();
				});
			</script>
			<div class="alert alert-success alert-dismissible collapse mb-2">
				{!! session('ok') !!}
			</div>
        @endif
		
		@if(session()->has('error'))
			<script type="text/javascript">
				$(function() {
					$('.collapse').collapse();
				});
			</script>

			<div class="alert alert-danger collapse mt-1 mb-2">
				<span>{!! session('error') !!}</span>
			</div>
        @endif

		<div id="homeBlock">
			<h2>@lang('Products based on ethics and quality !')</h2>
			<p><img src="{{ asset('img/nos_produits_locaux_morbihan.jpg') }}" alt="Présentation de nos producteurs locaux"/>@if(\Auth::user() && \Auth::user()->admin == 2) {!! link_to_route('admin.customText.edit', __('Edit this text'), [$customText->id], ['style'=>'color:#0f5132']) !!} -> @endif{{ (app()->getLocale() == 'fr') ? $customText->text : $customText->translation}}</p>
			
		</div>
		<h2>@lang('Last local products added')</h2>
		<div class="d-flex flex-wrap">
			@if($products->count() > 0)
				@foreach($products as $product)
						<article class="article-small">
							<a href="{{ route('product.index', array($product->id, $product->productCat->slug, $product->slug)) }}">
								<header>
									<img src="uploads/products/{{ $product->img }}" alt="{{ $product->product_name }}"/>
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
			@else
				<p class="alert alert-danger">@lang('No product registered at this time.')</p>
			@endif
		</div>
    @stop
