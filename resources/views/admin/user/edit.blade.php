@extends('layouts.app')   
	@section('title')
		@lang('Edit a user')
	@stop

	@section('middle')
		@if ($errors->any())
			<script type="text/javascript">
				$(function() {
					$('.alert.collapse').collapse();
				});
			</script>

			<div class="alert alert-danger collapse">
				{!! implode('', $errors->all('<span>:message</span><br/>')) !!}
			</div>
		@endif

    	<div class="offset-sm-4 col-sm-4">
    		<div class="card">
    			<h3 class="card-title">@lang('Edit a user')</h3>
    			<div class="card-body">
    				<div class="col-sm-12">
    					{!! Form::model($user, ['route'=>['admin.user.update', $user->id], 'method'=>'put','class'=>'form-horizontal panel']) !!}
						{{ csrf_field() }}
    					<div class="form-group" {!! $errors->has('firstname') ? 'has-error' : '' !!}">
    						{!! Form::text('firstname', null, ['class'=>'form-control', 'placeholder'=>__('Firstname')]) !!}
    						{!! $errors->first('firstname', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('lastname') ? 'has-error' : '' !!}">
    						{!! Form::text('lastname', null, ['class'=>'form-control', 'placeholder'=>__('Lastname')]) !!}
    						{!! $errors->first('lastname', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('phone') ? 'has-error' : '' !!}">
    						{!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>__('Phone (optional)')]) !!}
    						{!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('email') ? 'has-error' : '' !!}">
    						{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Email')]) !!}
    						{!! $errors->first('email', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('road') ? 'has-error' : '' !!}">
    						{!! Form::text('road', null, ['class'=>'form-control', 'placeholder'=>__('Road')]) !!}
    						{!! $errors->first('road', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('postal_code') ? 'has-error' : '' !!}">
    						{!! Form::text('postal_code', null, ['class'=>'form-control', 'placeholder'=>__('Postal code')]) !!}
    						{!! $errors->first('postal_code', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group" {!! $errors->has('city') ? 'has-error' : '' !!}">
    						{!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('City')]) !!}
    						{!! $errors->first('city', '<small class="help-block">:message</small>') !!}
    					</div>

    					<div class="form-group mb-1">
    						<div class="checkbox">
    							<label>
    								{!! Form::checkbox('admin', 1, null) !!} @lang('Producer')
    							</label>
    						</div>
    					</div>

    					{!! Form::submit(__('Edit'), ['class'=>'btn pull-right']) !!}
						<a href="{{ route('admin') }}" class="btn btn-primary">
			        		<span class="glyphicon glyphicon-circle-arrow-left"></span>@lang('Back')
			        	</a>
    					{!! Form::close() !!}
    				</div>
    			</div>
    		</div>
    	</div>
    @stop