@extends('email.template')

@section('title')
Votre forfait est arrivé à expiration.
@endsection

@section('mailTitle')
Votre forfait est arrivé à expiration.
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Votre souscription au forfait <b>{{ $plan->name }}</b> est arrviée à expiration. Nous sommes donc dans le regret de vous annoncer que vous ne bénéficiez désormais plus de nos services.</p>

	<p>Souhaitez-vous <a href="{{ route('plan.payment', $plan->id_plan) }}">renouveler votre souscription au même forfait</a> ou <a href="{{ route('plan.choose') }}">opter pour une autre offre</a> ?</p>

@endsection