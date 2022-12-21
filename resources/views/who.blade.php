@extends('layouts.app')
    @section('title')Qui sommes nous ? | Les paniers de Laoul'ane !@endsection

    @section('meta')
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ asset('img/nos_produits_locaux_morbihan.jpg')}}">
	@stop

    @section('middle')
        @if(!empty($supplier))
             <h2>@lang('Shop') {{$supplier->supplier_name}}</h2>
            <section class="suppliersP">
                    <div class="onlyOne">
                        <img src="{{asset('uploads/suppliers/'.$supplier->img)}}" alt="{{$supplier->supplier_name}}"/>
                        <p>{{$supplier->description}}</p>
                    </div>
                    <h3 class="mb-0 mt-2">@lang('My products') :</h3>
                    @if($products->count() > 0)
                        <div class="products d-flex flex-wrap">
                            @foreach($products as $product)
                                <article class="article-small mt-2">
                                    <a href="{{ route('product.index', array($product->id, $product->productCat->slug, $product->slug)) }}">
                                        <header>
                                            <img src="{{asset('uploads/products/'.$product->img) }}" alt="{{ $product->product_name }}"/>
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
                        
                        {!! $links !!}
                    @else
                        <p class="alert alert-danger mb-0">@lang('No product registered at this time.')</p>
                    @endif
            </section>
        @else
            <h2>@lang('Our local producers, at your service')</h2>
            <p class="mb-0">@if(\Auth::user() && \Auth::user()->admin == 2) {!! link_to_route('admin.customText.edit', __('Edit this text'), [$customText->id], ['style'=>'color:#0f5132']) !!} -> @endif{{ (app()->getLocale() == 'fr') ? $customText->text : $customText->translation}}</p>
            <section class="suppliersP d-flex flex-wrap mt-0 align-items-center">
                @foreach($suppliers as $supplier)
                    <div>
                        <h3>{{$supplier->supplier_name}}</h3>
                        <img src="{{asset('uploads/suppliers/'.$supplier->img)}}" alt="{{$supplier->supplier_name}}"/>
                        <p>{{\Illuminate\Support\Str::limit($supplier->description, 200, '...')}}</p>
                        <a class="btn btn__large" href="{{route('who.getById', $supplier->id)}}">@lang('Shop of') "{{$supplier->supplier_name}}"</a>
                    </div>
                @endforeach
            </section>
        @endif
	@endsection