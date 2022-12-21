@extends('layouts.app')

@section('title')404 ! | Les paniers de Laoul'ane @endsection

@section('middle')
<div class="row d-flex justify-content-center text-center">
  <div class="col-md-6">
	<div class="card bg-light">
		<div class="card-header">
			<h3 class="card-title">Oups !</h3>
		</div>

		<div class="card-body">
			<img style="border-radius:10em; width:50%; margin-top:1em;" src="{{ asset('img/local_suppliers.jpg') }}" alt="Erreur 404"/>
			<p>Nous sommes désolés, mais la page que vous désirez n'existe plus...</p>
		</div>
	</div>
  </div>
</div>
@endsection