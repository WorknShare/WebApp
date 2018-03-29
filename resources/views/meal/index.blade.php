@extends('layouts.frontoffice')

@section('title')
Réservation
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Réservation @endslot
	  @slot('description')Choix du site @endslot
	@endcomponent
@endsection

@section('content')
  @if(count($sites))
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
        <td style="max-width: 200px;" class="ellipsis" title="{{ $site->name }}"><b><a href="{{ route('meal.create', ["site" => $site->id_site]) }}">{{ $site->name }}</a></b></td>
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

  <div class="row bottom-controls">
  	<div class="col-xs-12">
  		{{ $links }}
  	</div>
  </div>

@endsection
