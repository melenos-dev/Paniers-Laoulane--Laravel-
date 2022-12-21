@extends('layouts.app')
    @section('title')
        {{ Auth::user()->firstname.' '.Auth::user()->lastname }} - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row me-0 ml-0 my-account">
            @if(session()->has('ok'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>
                <div style="padding-left:0.8rem; padding-right:0">
                    <div class="alert alert-success alert-dismissible collapse" style="margin-bottom:15px">
                        {!! session('ok') !!}
                    </div>
                </div>
            @elseif(session()->has('error'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>

                <div class="alert alert-danger collapse mt-1 mb-0">
                <span>{!! session('error') !!}</span>
                </div>
            @endif
            <div id="sidebar-left" class="col">
                <h2 class="mb-2">@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif
                <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('user.edit', Auth::user()->id) }}">@lang('Edit my personal data')</a><br/>
                @if($userHistory > 0)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('orders.historical') }}">@lang('My order history')</a><br/>
                @endif

                @if (Auth::user()->admin > 0)
                    <h3 class="mt-2 mb-1">@lang('My shop')</h3>
                    <div class="ariane">
                        <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('product.create') }}">@lang('Add a product')</a><br/>
                        <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('productCat.create') }}">@lang('Categories management')</a><br/>
                        <i class="fa-solid fa-arrow-right"></i> 
                        @if($supplier)
                        <a href="{{ route('supplier.edit', $supplier->id) }}">@lang('Edit my producer page')</a>
                        @else
                            <a href="{{ route('supplier.create') }}">@lang('Create my producer page')</a>
                        @endif
                        <br/>
                        <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('orders.merchant.historical') }}">@lang('My sales history')</a>
                    </div>

                    <h4 class="mb-2 mt-2 ml-2 delete"><i class="fa-solid fa-truck me-2"></i>@lang('Orders I have to deliver')</h4>
                    <div class="orders">
                    @forelse($merchantOrders as $merchantOrder)
                        <span class="divider">
                            <i class="fa-solid fa-arrow-right"></i>
                            <a href="{{ route('order.merchant.show', $merchantOrder->id) }}">
                                @lang('Order of') {{ \Carbon\Carbon::parse($merchantOrder->created_at)->translatedFormat('d M Y') }}
                            </a><br/>
                            @lang('Adressed by') : <b>{{ $merchantOrder->user->firstname.' '.$merchantOrder->user->lastname.' | '.$merchantOrder->total_price.' €' }}</b>
                        </span>
                    @empty
                        <p class="mb-0 mt-0 px-2">@lang('No orders') <i style="color:#018413" class="fa-solid fa-check"></i></p>
                    @endforelse
                    </div>
                    @if($merchantOrders->where('status', '=', '0')->count() > 1)
                        {!! Form::open(['method'=>'POST', 'files' => true, 'route'=>['orders.delivered'], 'style' => 'text-align:center']) !!}
                            {{ csrf_field() }}
                            {!! Form::submit(__('Confirm all deliveries').' !', ['class'=>'btn', 'onclick'=>'return confirm("'.__("Confirm all deliveries").' ?")']) !!}
                        {!! Form::close() !!}
                    @endif
                 @endif
            </div>  

            <div class="col pe-0">
                <div class="card">
                    <h2 class="card-title card-title-green">@lang('My basket') <i class="fa-solid fa-basket-shopping"></i></h2>
                    @if ($errors->any())
                        <script type="text/javascript">
                            $(function() {
                                $('.alert.collapse').collapse();
                            });
                        </script>

                        <div class="alert alert-danger collapse mt-1 mb-2">
                            {!! implode('', $errors->all('<span class="error">- :message</span>')) !!}
                        </div>
                    @endif
                    <div class="card-body d-flex">
                        <div class="articles">
                            @if($basket_products)
                                @foreach($basket_products as $basket_product)
                                    <article class="d-flex basket mb-4">
                                        <header>
                                            <img height="107.64" src="{{ asset('uploads/products/'.$basket_product->product->img.'')}}" alt="{{ $basket_product->product->product_name }}"/>
                                        </header>

                                        <section class="pe-2 d-flex w-100">
                                            <div>
                                                <span><b>{{ $basket_product->product->product_name }}</b><br/>
                                                @if($basket_product->product->product_price != '')
                                                    <span class="price">{{ $basket_product->product->priceRender() }} €</span><br/>
                                                @else
                                                    <span class="price">{{ $basket_product->product->product_total_price }} €</span><br/>
                                                @endif
                                                {{ $basket_product->product->productCat->name }}</span><br/>
                                                <span><b>Stock @lang('left') :</b> {{ $basket_product->product->getQuantity() < 0 ? '0' : $basket_product->product->getQuantity()}}</span><br/>
                                            </div>
                                            
                                            {!! Form::open(['method'=>'POST', 'route'=>['basket.edit', $basket_product->id]]) !!}
                                                {!! Form::hidden('product_id', $basket_product->product->id) !!}
                                                {!! Form::hidden('product_quantity', $basket_product->product->getQuantity()) !!}
                                                {!! Form::label('quantity', __('Quantity chosen')) !!}<br/>
                                                {!! Form::number('quantity', $basket_product->quantity, ['class'=>'form-control quantity', 'min'=>'0', 'max'=>'100', 'id'=>'quantity']) !!}
                                                {!! Form::submit(__('Ok'), ['class'=>'btn']) !!}<br/>
                                                <b class="price">-> {{ $basket_product->getPriceByQuantity() }} €</b>
                                            {!! Form::close() !!}
                                        </section>
                                    </article>
                                @endforeach
                            @else
                                <p class="mb-0 mt-0">@lang('Empty basket').</p>
                            @endif
                        </div>
                        @if(!empty($basket_product))
                            <div class="total px-2">
                                <h3 class="mb-1">@lang('Total amount')</h3>
                                <b class="price">{{ $basket_product->getTotalPrice() }} €</b>
                                {!! Form::open(['method'=>'POST', 'route'=>['order.add']]) !!}
                                    {!! Form::submit(__('Validate my basket'), ['class'=>'btn mt-2']) !!}<br/>
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>

                    <h2 class="card-title card-title-orange mb-0">@lang('My orders') <i class="fa-solid fa-credit-card"></i></h2>
                    <div class="card-body pb-0">
                        @forelse($userOrders as $userOrder)
                            <span class="divider">
                                <i class="fa-solid fa-arrow-right"></i>
                                <a href="{{ route('order.user.show', $userOrder->id) }}">
                                    @lang('Order of') {{ \Carbon\Carbon::parse($userOrder->created_at)->translatedFormat('d M Y') }}
                                </a> | @lang('Adressed to') :
                                <b>{{ $userOrder->merchant->firstname.' '.$userOrder->merchant->lastname.' | '.$userOrder->total_price.' €' }} --> <em>@lang('Awaiting delivery')</em></b>
                            </span>

                        @empty
                            <p class="px-0 pb-2 mb-0 mt-2">@lang('No orders').</p>
                        @endforelse
                    </div>
                    @if(Auth::user()->admin > 0)
                        <h2 class="card-title card-title-blue mb-0">@lang('My products') <i class="fa-solid fa-leaf"></i></h2>
                        <div class="card-body">
                            @if($products)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <th>Description</th>
                                            <th>@lang('Category')</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{!! $product->product_name !!}</td>
                                                <td>
                                                    {!! \Illuminate\Support\Str::limit($product->description, 40, '...') !!}
                                                </td>

                                                <td>
                                                    {!! $product->productCat->name !!}
                                                </td>

                                                <td align="right" width="40px">
                                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-block">Modifier</a>
                                                </td> 
                                                
                                                <td align="right" width="45px">
                                                    <a href="{{ route('product.destroy', $product->id) }}" onclick="return confirm({{ '\''.__('Delete this product ?').'\''}})" class="btn btn-danger btn-block">Supprimer</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!!$links!!}
                            @else
                                <p class="alert alert-danger mb-0">@lang('No product registered at this time.')</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection