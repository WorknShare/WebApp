@extends('layouts.frontoffice')

@section('title')
Commande
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Commande @endslot
	  @slot('description')Repas @endslot
	@endcomponent
@endsection

@section('content')
  @if(count($sites))
  	<h4>Sélectionnez un site</h4>
	  <div class="box-body no-padding table-container-responsive">
	    <table class="table table-striped">
	      <tr>
	        <th>Nom</th>
	        <th>Adresse</th>
	        <th style="width: 40px">Wifi</th>
	        <th style="width: 40px">Boissons</th>
	      </tr>
	      @foreach ($sites as $site)
		      <tr>
		        <td style="max-width: 200px;" class="ellipsis" title="{{ $site->name }}"><b><a href="{{ route('mealorder.create', ["site" => $site->id_site]) }}">{{ $site->name }}</a></b></td>
		        <td>{{ $site->address }}</td>
		        <td>{!! Html::badge($site->wifi) !!}</td>
		        <td>{!! Html::badge($site->drink) !!}</td>
		      </tr>
	  	@endforeach
	    </table>
	  </div>
  @else
	  <div class="row">
	  	<div class="col-xs-12">
	  		<h4 class="text-muted">Les réservations sont indisponible pour le moment</h4>
	  	</div>
	  </div>
  @endif

  <div class="row">
	<div class="col-xs-12">
	    {{ $links }}
	</div>
	<div class="col-xs-12 u-MarginBottom15">
	    <a class="btn btn-default btn-responsive pull-left" href='{{ route('myaccount.index') }}' type="button"><i class="fa fa-chevron-left u-MarginRight10"></i> Retour</a>
	</div>
  </div>

@endsection
