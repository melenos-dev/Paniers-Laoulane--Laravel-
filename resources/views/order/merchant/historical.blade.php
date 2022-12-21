@extends('layouts.app')
    @section('title')
        @lang('My sales history') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('My sales history')</span>
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
                <h2 class="pt-0 mb-2">Mon compte <i class="fa-solid fa-person-shelter"></i></h2>

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
                <h2>@lang('My sales history')</h2>
                @if($orders)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('Adressed by')</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th style="text-align:right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->user->firstname.' '.$order->user->lastname }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}
                                    </td>

                                    <td>
                                        {{ $order->total_price }} €
                                    </td>
                                    
                                    <td align="right">
                                        <a href="{{ route('order.merchant.show', $order->id) }}">@lang('Open details')</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!!$links!!}
                @else
                    <p class="alert alert-danger">@lang('No order registered at this time.')</p>
                @endif
            </div>
        </div>
    @endsection