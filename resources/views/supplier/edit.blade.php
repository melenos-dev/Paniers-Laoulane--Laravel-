@extends('layouts.app')
    @section('title')
        @lang('Edit my producer page') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Edit my producer page')</span>
            </div>

            <div id="sidebar-left" class="col my-2">
                <h2>@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                </div>
            </div>  

            <div class="col px-2 py-2">
                <div class="card px-2 pb-2">
                    @if ($errors->any())
                        <script type="text/javascript">
                            $(function() {
                                $('.collapse').collapse();
                            });
                        </script>

                        <div class="alert alert-danger collapse mt-1 mb-0">
                            {!! implode('', $errors->all('<span>:message</span><br/>')) !!}
                        </div>
                    @elseif (isset($error))
                        <script type="text/javascript">
                            $(function() {
                                $('.collapse').collapse();
                            });
                        </script>

                        <div class="alert alert-danger collapse mt-1 mb-0">
                        <span>{!! $error !!}</span>
                        </div>
                    @endif
                    
                    {!! Form::model($supplier, ['method'=>'put', 'files' => true, 'route'=>['supplier.update', $supplier->id]]) !!}
                        {{ csrf_field() }}
                        {!! Form::text('supplier_name', null, ['class'=>'form-control mt-2 mb-2']) !!}
                        {!! Form::label('img', __('Change page picture ->')); !!}
                        {!! Form::file('img', ['class'=>'form-control mt-2 mb-2']) !!}<br/>

                        {!! Form::textarea('description', null, ['class'=>'form-control rounded px-md-3 py-md-3 me-5', 'placeholder'=>'Description']) !!}

                        {!! Form::submit(__('Edit'), ['class'=>'btn btn__large mt-2']) !!}
                    {!! Form::close() !!}
                </div>  
            </div>
        </div>
    @endsection