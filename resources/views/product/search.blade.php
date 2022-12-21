@extends('layouts.app')   
	@section('meta')
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ asset('img/logo/logo.png')}}">
	@stop

	@section('title')@lang('Search a product') | Les paniers de Laoul'ane !@stop

	@section('ariane')
		<div class="ariane">
			<a href="{{ route('welcome') }}">@lang('Home')</span></a>
			<i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Search a product')</span>
        </div>
	@stop

	@section('middle')
        <div class="d-flex flex-wrap mt-2">
            @if($products)
                @foreach($products as $product)
                        <article class="article-small">
                            <a href="{{ route('product.index', array($product->id, $product->productCat->slug, $product->slug)) }}">
                                <header>
                                    <img src="{{ asset('uploads/products/'.$product->img) }}" alt="{{ $product->product_name }}"/>
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
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>

                <div class="alert alert-danger collapse mt-1 mb-0 text-center" style="margin:0 auto">
                <img style="border-radius:10em; width:150px; margin-bottom:0.5em" src="{{ asset('img/local_suppliers.jpg') }}" alt="Erreur 404"/><br/>
                <span>@lang('Sorry, your search returned nothing').</span>
                </div>
            @endif
        </div>
        {!! $links !!}
    @stop