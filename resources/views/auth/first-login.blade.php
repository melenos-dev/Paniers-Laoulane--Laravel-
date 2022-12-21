@extends('layouts.app')

    @section('title')
        Bienvenu(e) ! | Les paniers de Laoul'ane !
    @endsection
	@section('middle')
        <div class="text-center">
            <h2>@lang('Thanks for signing up !')</h2>
            <img style="border-radius:10em; width:200px; margin-top:1em; margin-bottom:1em;" src="{{ asset('img/local_suppliers.jpg') }}" alt="La mascotte !"/>
            <p>@lang('You can now') <a href="{{route('user.index')}}">@lang('log in')</a>, @lang('and, if you wish, start making your reservations.')<br/>@lang('See you soon !')</p>
        </div>
    @endsection