<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h2>Nouvelle inscription sur le site :</h2>
        <ul>
        	<li><strong>Nom</strong> : {{firstname}}</li>
        	<li><strong>Prénom</strong> : {{firstname}}</li>
        	<li><strong>Pseudo : </strong> : {{pseudo}}</li>
        </ul>
    </body>
</html>
