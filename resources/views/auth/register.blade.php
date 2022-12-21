@extends('layouts.app')

@section('title')@lang('Subscribe') - Les paniers de Laoul'ane !@endsection

@section('middle')
            <h2>@lang('Welcome !') <i class="fa-solid fa-cow"></i></h2>
            <p class="mt-1">
                @lang('To save time (for example in a future order), we invite you to fill in your information now.') 
            </p>
            @if ($errors->any())
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>

                <div class="alert alert-danger collapse mt-2 mb-3" style="border-radius:20px;">
                    {!! implode('', $errors->all('<span class="error">- :message</span>')) !!}
                </div>
            @endif
            {!! Form::open(['method'=>'POST', 'route'=>['auth.first-login']]) !!}
                {{ csrf_field() }}
                <div class="input-group mb-2">
                        {!! Form::text('firstname', null, ['class'=>$errors->first('firstname', 'is-invalid ') .'form-control py-md-3 me-3', 'placeholder'=>__("Firstname"), 'required' => 'required']) !!}
                        {!! Form::text('lastname', null, ['class'=>$errors->first('lastname', 'is-invalid ') .'form-control py-md-3', 'placeholder'=>__("Lastname"), 'required' => 'required']) !!}
                </div>

                <div class="input-group mb-2">
                    {!! Form::text('phone', null, ['class'=>$errors->first('phone', 'is-invalid ') .'form-control py-md-3 me-3', 'placeholder'=>__("Phone (optionnal)")]) !!}
                    {!! Form::text('email', null, ['class'=>$errors->first('email', 'is-invalid ') .'form-control py-md-3', 'placeholder'=>'E-Mail']) !!}
                </div>

                <div class="input-group mb-2">
                    <div class="col">
                        {!! Form::password('password', ['class'=>$errors->first('password', 'is-invalid ') .'form-control py-md-3 me-3', 'placeholder'=>__("Password"), 'required' => 'required']) !!}
                    </div>
                </div>

                <h2 class="mb-2">@lang('And your address') :</h2>

                <div class="input-group mb-2">
                    {!! Form::text('road', null, ['class'=>$errors->first('road', 'is-invalid ') .'form-control py-md-3 me-3', 'placeholder'=>__("Road"), 'required' => 'required']) !!}
                    {!! Form::text('postal_code', null, ['class'=>$errors->first('postal_code', 'is-invalid ') .'form-control py-md-3', 'placeholder'=>__("Postal code"), 'required' => 'required']) !!}
                </div>

                {!! Form::text('city', null, ['class'=>$errors->first('city', 'is-invalid ') .'form-control py-md-3 me-3', 'placeholder'=>__("City"), 'required' => 'required']) !!}
                {!! Form::submit(__("Subscribe !"), ['class'=>'btn mt-3 btn__large']) !!}
            {!! Form::close() !!}
@endsection
