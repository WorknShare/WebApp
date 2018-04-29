@extends('email.template')

@section('title')
Votre forfait arrive à expiration.
@endsection

@section('mailTitle')
Votre forfait arrive à expiration.
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>
		Votre souscription au forfait <b>{{ $plan->name }}</b> arrive à expiration dans moins de 7 jours.
	</p>

	<p>Souhaitez-vous <a href="{{ route('plan.payment', $plan->id_plan) }}">renouveler votre souscription au même forfait</a> ou <a href="{{ route('plan.choose') }}">opter pour une autre offre</a> ?</p>
@endsection