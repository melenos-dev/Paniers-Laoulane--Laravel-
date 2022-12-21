<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <img style="width:200px;display:block;margin:0 auto 10px auto;" src="{{asset('img/logo/logo.png')}}" alt="Logo"/>
        <h2 class="text-center">Merci pour votre inscription {{$firstname}}.</h2>
        <p>Vous pouvez dès à présent <a href="{{route('user.index')}}" target="_blank">vous connecter</a> et si vous le désirez, commencer vos réservations.<br/>
        A très vite !<br/><br/>
        <strong style="font-size:120%">Les paniers de Laoul'ane</strong></p>
    </body>
</html>
