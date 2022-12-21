@extends('layouts.app')   
	@section('meta')
		<meta property="og:type" content="product">
		<meta property="og:description" content="{{ $product->description }}">
		<meta property="og:image" content="{{ asset('uploads/products/'.$product->img.'')}}">
		<meta property="product:price:amount" content="{{$product->product_price != '' ? $product->priceRender() : $product->product_total_price}}">
        <meta property="product:price:currency" content="EUR">
	@stop

	@section('title'){{$product->product_name}} - {{ $product->productCat->name }}, acheter | Les paniers de Laoul'ane !@stop

	@section('ariane')
		<div class="ariane">
			<a href="{{ route('welcome') }}">@lang('Home')</span></a>
			@foreach ($ariane as $category)
				@php
					echo $category
				@endphp
			@endforeach
			<i class="fa-solid fa-arrow-right"></i> <span class="active">{{$product->product_name}}</span>
        </div>

		@if(session()->has('ok'))
			<script type="text/javascript">
				$(function() {
					$('.alert.collapse').collapse();
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

		<article class="article d-flex align-items-center">
			<header>
				<img src="{{ asset('uploads/products/'.$product->img.'')}}" alt="{{ $product->product_name }}"/>
			</header>
			
			<section>
				<h2 class="mb-2">{{$product->product_name}}</h2>
				@if($product->product_price != '')
					<span class="price">{{ $product->priceRender() }} €</span><br/>
				@else
					<span class="price">{{ $product->product_total_price }} €</span><br/>
				@endif
				<a title="@lang('Open category') {{$product->productCat->name}}" style="font-weight:bold" href="{{ route('productCat.index',  array($product->productCat->id, $product->productCat->slug)) }}">{{ $product->productCat->name }}</a><br/>
				<span>{{ $product->product_weight }} kg</span><br/>
				@if($product->product_price != '')
					<span>@lang('Price per kg') : {{ $product->product_price }} €</span><br/>
				@endif

				<span>Stock : <span {{ ($product->getQuantity() > 6) ? 'style=color:#018413;' : 'style=color:#842029;' }}>{{ $quantity }}</span></span><br/>
				<span>@lang('Producer') : <a title="@lang('More info about') {{$supplier->supplier_name}}" href="{{route('who.getById', $supplier->id)}}">{{ $supplier->supplier_name }}</a></span><br/>
				<p class="mt-2">{{$product->description}}</p>
				@guest 
				<p class="alert alert-danger"> 
					@lang('To add this product to your basket, please') <a data-bs-toggle="modal" class="login" data-bs-target="#loginModal" href="#loginModal">@lang('log in')</a>
                </p>
				@else
				@if($quantity != __('Out of stock'))
				{!! Form::open(['method'=>'POST', 'route'=>['basket.add']]) !!}
					{{ csrf_field() }}
					{!! Form::label('quantity', __('Quantity').'') !!}<br/>
					{!! Form::number('quantity', 1, ['class'=>'form-control quantity', 'min'=>'1', 'max'=>'100', 'id'=>'quantity']) !!}<br/>
					{!! Form::hidden('product_id', $product->id) !!}
					{!! Form::hidden('product_quantity', $product->getQuantity()) !!}
					{!! Form::hidden('previousUrl', url()->previous()) !!}
					@if ($errors->any())
						<script type="text/javascript">
							$(function() {
								$('.alert.collapse').collapse();
							});
						</script>

						<div class="alert alert-danger collapse mt-2 mb-0">
							{!! implode('', $errors->all('<span>:message</span><br/>')) !!}
						</div>
					@endif
					{!! Form::submit(__('Add to basket'), ['class'=>'btn btn__large mt-3']) !!}
                {!! Form::close() !!}
				@endif
				@endguest
			</section>
		</article>

		@if($products = $categories->allProductsByParent($product->productCat)->where('id', '!=', $product->id)->take(8))
				@if($products->count() > 0)
					<h3 class="mt-3">@lang('Some similar products') :</h3>
					<div class="d-flex flex-wrap mt-1">
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
					</div>
				@endif
			@endif

		<script>
			$(document).ready(function(){
				$(document).on('click', '.add', function(event){
					event.preventDefault(); 
					let id = $(this).split('id=')[1];
					fetch_data(id);
				});

				function fetch_data(id)
				{
					$.ajax({
						url:"/panier/ajouter?id="+id,
						success:function(data)
						{
							$(this).addClass('added');
						}
					});
				}
			});
		</script>
    @stop