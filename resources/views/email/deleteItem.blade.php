@extends('email.template')

@section('title')
Matériel supprimé
@endsection

@section('mailTitle')
Matériel supprimé
@endsection

@section('content')
	<p>Bonjour {{ $username }},</p>
	<p>Le matériel {{$serial_number}} de votre réservation n°{{$command_number}} a été retiré à cause de problèmes techniques</p>
@endsection
