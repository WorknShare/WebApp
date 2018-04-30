@extends('email.template')

@section('title')
Votre forfait arrive à expiration.
@endsection

@section('mailTitle')
Votre forfait arrive à expiration.
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Votre souscription au forfait <b>{{ $plan->name }}</b> arrive à expiration <b>le {{ date_format(new DateTime($payment->limit_date), 'd/m/Y') }}</b>, c'est à dire dans moins de 7 jours.</p>

	<p>Souhaitez-vous <a href="{{ route('plan.payment', $plan->id_plan) }}">renouveler votre souscription au même forfait</a> ou <a href="{{ route('plan.choose') }}">opter pour une autre offre</a> ?</p>

	<p>Renouveler votre souscription au même forfait étendra la date de validité d'un mois. Si vous renouvelez dès maintenant, le temps restant actuel ne sera pas perdu.<br>
	Changer de forfait mettra immédiatement fin à votre souscription actuelle. Le temps restant sera alors perdu.<br>
	Si vous n'effectuez pas de nouvelle souscription avant le {{ date_format(new DateTime($payment->limit_date), 'd/m/Y') }}, vous perdrez les avantages liés à votre souscription.</p>
@endsection