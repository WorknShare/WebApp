@extends('email.template')

@section('title')
Commande annulée
@endsection

@section('mailTitle')
Commande annulée
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Votre commande de repas n°{{$command_number}} a été annulée !</p>

	<h4>Pourquoi a-t-elle été annulée ?</h4>
	<p>{{$message_send}}</p>
@endsection
