@extends('email.template')

@section('title')
Réservation annulée
@endsection

@section('mailTitle')
Réservation annulée
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Votre réservation n°{{$command_number}} a été annulé !</p>

	<h4>Pourquoi a-t-elle été annulé?</h4>
	<p>{{$message_send}}</p>
@endsection
