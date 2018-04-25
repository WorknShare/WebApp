@extends('layouts.frontoffice')

@section('title')
	Work'n Share - Information personnelles
@endsection

@section('page_title')
	@component('components.header')
		@slot('title')Profil @endslot
		@slot('description')Vos informations @endslot
	@endcomponent
@endsection

@section('css')
	<style>
	.account-section {
		font-size: 19px;
	}

	.account-section-h {
		margin-top : 50px;
		text-align : center;
		border-bottom : 2px solid gray;
		padding : 10px;
		margin-bottom : 50px;
	}

	.account-info {
		color: #3C8DBC;
	}

	.btn-row .btn {
		margin-top: 15px;
	}
	</style>
	<link rel="stylesheet" href="{{ asset('landing/css/responsive_buttons.css') }}">
@endsection

@section('content')

	@if(!empty($planWarning))
		<div class="alert alert-warning"><i class="fa fa-warning"></i> Votre forfait expire <b>{{ $planWarning }}</b>. <a href="{{ route('plan.payment', $userPlan->id_plan) }}">Renouveler mon forfait</a>.</div>
	@endif

	@if(session()->has('ok'))
	<div id="successMeal" class="alert alert-success alert-dismissible"><i class="fa fa-check"></i><b class="overflow-break-word">{!! session('ok') !!}</b></div>
	@endif

	<div class="row">
		<div class="col-xs-12">
			<h3 class="account-section-h">Informations personnelles</h3>
			<div class="row account-section">
				<div class="col-xs-12 col-sm-6 col-md-4">
					Nom: <span class="account-info">{{ $user->name }}</span>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					Prénom: <span class="account-info">{{ $user->surname }}</span>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					Email: <span class="account-info">{{ $user->email }}</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row btn-row">
		<div class="col-xs-12 col-sm-6">
			<a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.editpwd') }}'> Changer mon mot de passe</a>
		</div>
		<div class="col-xs-12 col-sm-6">
			<a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.qrcode') }}'> Votre QR code</a>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<h3 class="account-section-h">Forfait</h3>
			<div class="row account-section">
				<div class="col-xs-12 col-sm-6 col-md-4">
					Forfait: <span class="account-info">{{ !empty($plan) ? $plan->name : 'Aucun forfait' }}</span>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					Description: <span class="account-info">{{ !empty($plan) ? $plan->description : '' }}</span>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					Fin de validité: <span class="account-info">{{ !empty($limitDate) ? $limitDate : 'N/A' }}</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row btn-row">
		<div class="col-xs-12 col-sm-6">
			<a class="btn btn-block btn-primary btn-responsive" href='{{ route('plan.choose') }}'> Changer de forfait</a>
		</div>
		<div class="col-xs-12 col-sm-6">
			<a class="btn btn-block btn-primary btn-responsive" href='{{ route('plan.history') }}'> Historique</a>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<h3 class="account-section-h">Réservations</h3>
			<div class="row">
				<div class="col-xs-12 col-sm-4">
					<a class="btn btn-block btn-primary btn-responsive" href='{{ route('order.index') }}'>Réserver une salle</a>
				</div>
				<div class="col-xs-12 col-sm-4">
					<a class="btn btn-block btn-primary btn-responsive" href='{{ route('mealorder.index') }}'>Commander un repas</a>
				</div>
				<div class="col-xs-12 col-sm-4">
					<a class="btn btn-block btn-primary btn-responsive" href='{{ route('order.history') }}'>Votre historique</a>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			$('#successMeal').delay(4000).hide('slow');
		});
	</script>
@endsection
