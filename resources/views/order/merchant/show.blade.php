@extends('layouts.app')
    @section('title')
        #{{ $order->id }} - @lang('My sales history') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
        <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('orders.merchant.historical') }}">@lang('My sales history')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">#{{ $order->id }}, {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}</span>
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

            <div id="sidebar-left" class="col my-2">
                <h2>Mon compte <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                </div>

                @if ($errors->any())
                    <script type="text/javascript">
                        $(function() {
                            $('.alert.collapse').collapse();
                        });
                    </script>

                    <div class="alert alert-danger collapse mt-1 mb-0">
                        {!! implode('', $errors->all('<span>:message</span><br/>')) !!}
                    </div>
                @elseif (isset($error))
                    <script type="text/javascript">
                        $(function() {
                            $('.alert.collapse').collapse();
                        });
                    </script>

                    <div class="alert alert-danger collapse mt-1 mb-0">
                    <span>{!! $error !!}</span>
                    </div>
                @endif
            </div>  

            <div class="col px-2 py-2">
                <div class="card">
                    <h2 class="card-title">@lang('Adressed by') {{ $order->user->firstname.' '.$order->user->lastname }}</h2>
                    <div class="card-body d-flex">
                        <div class="articles">
                            <span class="mb-2 d-block"><i class="fa-solid fa-calendar-days"></i> Le {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }} | <b>#</b>{{ $order->id }}</span>
                            @foreach($order->products as $product)
                                <article class="d-flex basket mb-4 pb-2">
                                    <header>
                                        <img height="107.64" src="{{ asset('uploads/products/'.$product->img.'')}}" alt="{{ $product->product_name }}"/>
                                    </header>

                                    <div class="d-flex w-100">
                                        <div class="px-2">
                                            <span><b>{{ $product->product_name }}</b><br/>
                                            {{ $product->productCat->name }}</span><br/>
                                            <span><b>@lang('Quantity') :</b> {{ $product->pivot->quantity }}</span><br/>
                                            <span><b>@lang('Total price') : </b>{{ $product->getPriceByQuantity() }} €</span>
                                        </div>

                                        <div class="px-2 ml-2" style="border-left: 1px solid #f1c232;">
                                            <b>
                                                <span>{{ $order->user->road }}</span><br/>
                                                <span>{{ $order->user->postal_code }}</span><br/>
                                                <span>{{ $order->user->city }}</span><br/>
                                                <span>{{ $order->user->phone }}</span><br/>
                                            </b>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="total px-2">
                            <h3 class="mb-1">@lang('Total amount')</h3>
                            <b class="price">{{ $order->total_price }} €</b>
                            @if($order->status == 0)
                            {!! Form::open(['method'=>'POST', 'files' => true, 'route'=>['order.delivered', $order->id]]) !!}
                                {{ csrf_field() }}
                                {!! Form::submit(__('Order delivered').' !', ['class'=>'btn mt-2', 'onclick'=>'return confirm("'.__("Confirm delivery ?").'")']) !!}
                            {!! Form::close() !!}
                            @else
                                <p class="alert alert-success">
                                    @lang('This delivery has been confirmed').
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection