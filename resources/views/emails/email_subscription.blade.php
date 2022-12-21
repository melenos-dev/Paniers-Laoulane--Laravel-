<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <img style="width:200px;display:block;margin:0 auto 10px auto;" src="{{asset('img/logo/logo.png')}}" alt="Logo"/>
        <h2>Nouvelle inscription sur le site !</h2>
        <p>
        	Nom : <b>{{$lastname}}</b><br/>
        	Prénom : <b>{{$firstname}}</b><br/>
        	Email : <b>{{$email}}</b><br/>
        	@if(!empty($phone))
                Téléphone : <b>{{$phone}}</b>
            @endif
            <br/><br/>
            <strong style="font-size:120%">Les paniers de Laoul'ane</strong>
        </p>
    </body>
</html>
