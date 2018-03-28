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
	tr {
		font-size : 19px;
		color: #3C8DBC;
	}
	td {
		padding-right : 3em;
		padding-bottom : 1.5em;
	}
	a.btn.btn-block.btn-primary.btn-lg {
		margin-bottom: 1em;
	}

	h3 {
		margin-top : 50px;
		text-align : center;
		border-bottom : 2px solid gray;
		padding : 10px;
		margin-bottom : 50px;
	}
	</style>
	<link rel="stylesheet" href="{{ asset('landing/css/responsive_buttons.css') }}">
@endsection

@section('content')

	@if(!empty($planWarning))
		<div class="alert alert-warning"><i class="fa fa-warning"></i> Votre forfait expire <b>{{ $planWarning }}</b>. <a href="{{ route('plan.payment', $userPlan->id_plan) }}">Renouveler mon forfait</a>.</div>
	@endif

	<div class="row">
		<div class="col-xs-12">
			<h1 style="text-align : center; padding : 4%">Votre compte</h1>
			<div class="row">
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<h3>Vos informations personnelles</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-2 col-lg-offset-4">
								<table>
									<tr>
										<td class="fixe">Nom</td>
										<td>{{$user->name}}</td>
									</tr>
									<tr>
										<td>Prénom</td>
										<td>{{$user->surname}}</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>{{$user->email}}</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.edit', $user->id_client) }}'> Modifier</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<h3>&nbsp;<br>Forfait</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-1 col-lg-offset-3">
								<table>
									<tr>
										<td class="fixe">Forfait</td>
										<td>{{ !empty($plan) ? $plan->name : 'Aucun forfait' }}</td>
									</tr>
									<tr>
										<td>Description</td>
										<td>{{ !empty($plan) ? $plan->description : '' }}</td>
									</tr>
									<tr>
										<td>Fin de validité</td>
										<td>{{ !empty($limitDate) ? $limitDate : 'N/A' }}</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-3 col-xs-6">
								<a class="btn btn-block btn-primary btn-responsive" href='{{ route('plan.choose') }}'> Changer de forfait</a>
								<a class="btn btn-block btn-primary btn-responsive" href='{{ route('plan.history') }}'> Historique</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<h3>Vos Actions</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.editpwd') }}'> Changer mon mot de passe</a>
								<a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.qrcode') }}'> Votre QrCode</a>
								<a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.qrcode') }}'> Votre historique</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-lg-offset-3 col-lg-7 col-xs-12">
								<h3>Nous contacter</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-offset-3">
								<table>
									<tr>
										<td class="fixe">Numéro</td>
										<td>06 06 06 06 06</td>
									</tr>
									<tr>
										<td>email</td>
										<td>contact@worknshare.fr</td>
									</tr>
									<tr>
										<td>adresse</td>
										<td>242, Rue Du Faubourg Saint Antoine </br> 75012 PARIS</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
