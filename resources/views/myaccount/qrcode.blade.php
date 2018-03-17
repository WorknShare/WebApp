@extends('layouts.frontoffice')

@section('title')
information personnelles
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Profil @endslot
	  @slot('description')QrCode @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('myaccount.index') }}"><i class="fa fa-home"></i>Vos informations</a></li>
	<li class="active">Qrcode</li>
@endsection


@section('content')
  <div class="row">
  	<div class="col-xs-12">
				<h1 style="text-align : center; padding : 4%">Votre QrCode</h1>
			<div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="col-md-offset-3">
            <img src= "{{ route('myaccount.qrcodedisplay')}}" alt="your QrCode">
          </div>
        </div>
			</div>
      <div class="row" style="margin-top : 5%">
        <div class="col-md-offset-5 col-md-2">
          <a class="btn btn-block btn-primary btn-lg" href='{{ route('myaccount.qrcodedownload')}}'> Télécharger </a>
          <a class="btn btn-block btn-default btn-lg" href='{{ route('myaccount.index')}}'> Retour </a>
        </div>
      </div>
  	</div>
  </div>
@endsection
