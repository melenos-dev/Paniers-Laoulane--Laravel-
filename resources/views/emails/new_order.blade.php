<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body style="font-size:120%;">
        <img style="width:200px;display:block;margin:0 auto 10px auto;" src="{{asset('img/logo/logo.png')}}" alt="Logo"/>
        <h2>@lang('New order recorded !')</h2>
        <p>
            <b>{{ $from }}</b> @lang('has just reserved the following product(s) for you :')<br/><br/>
            @foreach($products_basket as $basket)
                <div style="margin-bottom:10px; border-radius:15px; background-color:#F9F9F9; border:1px solid #f1c232; font-weight:bold;">
                    <div style="border:20px solid #F9F9F9; border-radius:15px;">
                        <span>{{ $basket->product->product_name }}</span><br/>
                        <span>{{ $basket->product->productCat->name }}</span><br/>
                        <span>@lang('Quantity') : {{ $basket->quantity }}</span><br/>
                        <span style="color:#018413; font-size:120%">{{ $basket->getPriceByQuantity() }} €</span>
                    </div>
                </div>
            @endforeach

            <span style="color:#7a3f15; font-size:150%">TOTAL : {{ $total_price }} €</span><br/><br/>
            <span>@lang("Once the order has been delivered, remember to validate it on your seller space.")</span><br/>
            <b>@lang('You can') <a style="color:#018413" href="{{ route('user.index') }}" target="_blank">@lang('click here')</a> @lang('to access it').</b>
            <br/><br/>
            <span style="font-size:120%">Les paniers de Laoul'ane</span>
        </p>
    </body>
</html>
