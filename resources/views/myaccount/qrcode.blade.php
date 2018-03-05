@extends('layouts.frontoffice')

@section('title')
information personnelles
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Information personnelles @endslot
	  @slot('description')Vos informations @endslot
	@endcomponent
@endsection


@section('content')

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
	</style>
  <div class="row">
  	<div class="col-xs-12">
				<h1 style="text-align : center; padding : 4%">Votre QrCode</h1>
			<div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="col-md-offset-3">
            <img src= "{{ $contents}}" alt="Card image cap">
          </div>
        </div>
			</div>
      <div class="row" style="margin-top : 5%">
        <div class="col-md-offset-5 col-md-2">
          <a class="btn btn-block btn-primary btn-lg" href='{{ $contents}}' download = {{'qrcode.'.$user->name.'.png'}}> Télécharger </a>
          <a class="btn btn-block btn-default btn-lg" href='{{ route('myaccount.index')}}'> Retour </a>
        </div>
      </div>
  	</div>
  </div>
@endsection



@section('scripts')
{!! iCheckScript() !!}
@endsection
