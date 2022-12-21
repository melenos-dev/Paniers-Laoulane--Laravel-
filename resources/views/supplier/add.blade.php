@extends('layouts.app')
    @section('title')
        @lang('Create my producer page') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Create my producer page')</span>
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

            @elseif(session()->has('error'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>
                <div class="alert alert-danger collapse mb-0">
                    {!! session('error') !!}
                </div>
            @endif

            <div id="sidebar-left" class="col my-2">
                <h2>@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

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
                    <h2 class="card-title">@lang('Create my producer page')</h2>
                    <div class="card-body">
                        {!! Form::open(['method'=>'POST', 'files' => true, 'route'=>['supplier.store']]) !!}
                            {{ csrf_field() }}
                            {!! Form::text('supplier_name', null, ['class'=>'form-control mt-2 mb-2', 'id'=>'addSupplier', 'placeholder'=>__('Title')]) !!}
                            {!! Form::label('img', __('Photo of my producer page ->')); !!}
                            {!! Form::file('img', ['class'=>'form-control mt-2 mb-2', 'autocomplete' => 'img']) !!}<br/>

                            {!! Form::textarea('description', null, ['class'=>'form-control rounded px-md-3 py-md-3 me-5', 'placeholder'=>'Description']) !!}

                            {!! Form::submit('Ajouter', ['class'=>'btn mt-2']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endsection