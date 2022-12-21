@extends('layouts.app')
    @section('title')
        @lang('Edit my personal data') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Edit my personal data')</span>
            </div>
            <div id="sidebar-left" class="col">
                <h2 class="mb-2">@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                </div>
            </div>  

            <div class="col pb-0">
                <div class="card px-2 pb-2">
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

                    {!! Form::model($user, ['method'=>'put', 'route'=>['user.update', $user->id]]) !!}
                        {{ csrf_field() }}
                        <h2 class="my-2">@lang('Edit my personal data')</h2>
                        @if($user->admin > 0)
                            {!! Form::hidden('admin', $user->admin) !!}
                        @endif
                        <div class="form-group" {!! $errors->has('firstname') ? 'has-error' : '' !!}">
    						{!! Form::text('firstname', null, ['class'=>'form-control', 'placeholder'=>'Prénom']) !!}
    						{!! $errors->first('firstname', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('lastname') ? 'has-error' : '' !!}">
    						{!! Form::text('lastname', null, ['class'=>'form-control', 'placeholder'=>'Nom']) !!}
    						{!! $errors->first('lastname', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('phone') ? 'has-error' : '' !!}">
    						{!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Téléphone']) !!}
    						{!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('email') ? 'has-error' : '' !!}">
    						{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
    						{!! $errors->first('email', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('road') ? 'has-error' : '' !!}">
    						{!! Form::text('road', null, ['class'=>'form-control', 'placeholder'=>'Rue']) !!}
    						{!! $errors->first('road', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('postal_code') ? 'has-error' : '' !!}">
    						{!! Form::text('postal_code', null, ['class'=>'form-control', 'placeholder'=>'Code postal']) !!}
    						{!! $errors->first('postal_code', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('city') ? 'has-error' : '' !!}">
    						{!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>'Ville']) !!}
    						{!! $errors->first('city', '<small class="help-block">:message</small>') !!}
    					</div>
                        {!! Form::submit(__('Edit'), ['class'=>'btn mt-2 btn__large']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('js/form.js') }}"></script>
    @endsection