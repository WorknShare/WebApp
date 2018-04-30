@extends('email.template')

@section('title')
Bienvenue chez Work'n Share !
@endsection

@section('mailTitle')
Bienvenue chez Work'n Share !
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Nous vous souhaitons bienvenue dans l'univers Work'n Share et n'attendons plus que votre visite sur nos sites !</p>

	<h4>Par où commencer ?</h4>
	<p>Afin de pouvoir profiter de nos services, pensez à souscrire à <a href="{{ route('plan.choose') }}">l'un de nos forfaits</a>.</p>
	<p>Vous pourrez ensuite effectuer des réservations et des commandes à partir de votre <a href="{{ route('myaccount.index') }}">page personnelle</a>.</p>
	<p>Nous nous tenons à votre disposition pour toute question ou remarque de votre part.</p>
@endsection