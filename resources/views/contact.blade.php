@extends('layouts.app')
    @section('title')Contact | Les paniers de Laoul'ane !@endsection

	@section('meta')
		<meta property="og:type" content="website">
		<meta property="og:image" content="{{ asset('img/logo/logo.png')}}">
	@stop

    @section('middle')
		<div class="col-sm-offset-3 col-sm6">
			<div class="panel panel-info">
				<div class="pannel-heading"><h2 class="mb-3">@lang('Here for a message, we will answer you as soon as possible')</h2></div>
				<div class="panel-body">
					{!! Form::open(['route'=>'contact.post', 'method'=>'post']) !!}
					<div class="form-group">
						<input id="firstname" type="text" placeholder="@lang('Firstname')" class="form-control @if($errors->has('firstname')) is-invalid @endif" name="firstname" value="{{ (\Auth::user() && \Auth::user()->firstname) ? \Auth::user()->firstname : old('firstname') }}" required autocomplete="firstname">
						{!! $errors->first('firstname', '<small class="invalid-feedback" role="alert">:message</small>') !!}
					</div>

					<div class="form-group">
						<input id="lastname" type="text" placeholder="@lang('Lastname')" class="form-control @if($errors->has('lastname')) is-invalid @endif" name="lastname" value="{{ (\Auth::user() && \Auth::user()->lastname) ? \Auth::user()->lastname : old('lastname') }}" required autocomplete="lastname">
						{!! $errors->first('lastname', '<small class="invalid-feedback" role="alert">:message</small>') !!}
					</div>

					<div class="form-group">
						<input id="email" type="email" placeholder="@lang('Email')" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ (\Auth::user() && \Auth::user()->email) ? \Auth::user()->email : old('email') }}" required autocomplete="email">
						{!! $errors->first('email', '<small class="invalid-feedback" role="alert">:message</small>') !!}
					</div>

					<div class="form-group">
						<textarea id="msg" placeholder="@lang('Message')" style="min-height:200px;" class="form-control @if($errors->has('msg')) is-invalid @endif" name="msg" value="{{ old('msg') }}" required autocomplete="msg"></textarea>
						{!! $errors->first('msg', '<small class="invalid-feedback" role="alert">:message</small>') !!}
					</div>
						{!! Form::submit(__('Submit'), ['class'=>'btn btn-info btn__large']) !!}
					{!! Form::close()!!}
				</div>
			</div>
		</div>
	@endsection