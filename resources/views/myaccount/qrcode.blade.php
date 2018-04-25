@extends('layouts.frontoffice')

@section('title')
QR Code
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Profil @endslot
	  @slot('description')QR Code @endslot
	@endcomponent
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('landing/css/responsive_buttons.css') }}">
@endsection

@section('content')
  <div class="row">
  	<div class="col-xs-12">
				<h1 style="text-align : center;">Votre QrCode</h1>
			<div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="col-md-offset-3">
            <img src= "{{ route('myaccount.qrcodedisplay')}}" alt="your QrCode">
          </div>
        </div>
			</div>
      <div class="row u-MarginTop15">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
          <a class="btn btn-block btn-primary btn-responsive" href='{{ route('myaccount.qrcodedownload')}}'> Télécharger </a>
        </div>
      </div>
  	</div>
  </div>
  <div class="row">
    <div class="col-xs-12 u-MarginBottom15 u-MarginTop15">
      <a class="btn btn-default btn-responsive pull-left" href='{{ route('myaccount.index') }}' type="button"><i class="fa fa-chevron-left u-MarginRight10"></i> Retour</a>
    </div>
  </div>
@endsection
