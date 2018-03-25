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
		padding: 2%;
		color: #3C8DBC;
	}
	td {
		padding-right : 2em;
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
@endsection

@section('content')

  <div class="row">
  	<div class="col-xs-12">
			<h1 style="text-align : center; padding : 4%">Votre compte</h1>
			<div class="row">
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-xs-offset-3 col-xs-6">
								<h3>Vos informations personnelles</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-3">
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
							<div class="col-xs-offset-3 col-xs-6">
								<a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.edit', $user->id_client) }}'> Modifier</a>
							</div>
						</div>
		  			</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-xs-offset-3 col-xs-6">
								<h3>Votre forfait</br> en cours</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-3">
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
								<a class="btn btn-block btn-primary btn-lg" href='{{ route('plan.choose') }}'> Changer de forfait</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
							<div class="row">
								<div class="col-xs-offset-3 col-xs-6">
			            			<h3>Vos Actions</h3>
			          			</div>
							</div>
							<div class="row">
								<div class="col-xs-offset-3 col-xs-6">
									<a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.editpwd') }}'> Changer mon mot de passe</a>
									<a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.qrcode') }}'> Votre QrCode</a>
									<a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.qrcode') }}'> Votre historique</a>
								</div>
							</div>
		  			</div>
				</div>
				<div class="col-lg-6">
					<div class="box box-solid">
						<div class="row">
							<div class="col-xs-offset-3 col-xs-6">
								<h3>Nous contacter</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-offset-3">
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
