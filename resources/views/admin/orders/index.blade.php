@extends('layouts.backoffice')

@section('title')
Réservations
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Réservations @endslot
	  @slot('description')Liste des réservations @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Réservations</li>
@endsection

@section('content')

<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4 pull-right">
    <form action="{{ route('order.index_admin') }}" method="get" id="formSearch">
      <div class="form-group has-feedback">
        <input class="form-control " placeholder="Recherche" id="search" maxlength="255" name="search" type="text" value='{{ isset($_GET["search"]) ? $_GET["search"] : '' }}'>
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </form>
  </div>
</div>
@if(count($orders))

<div class="box-body no-padding table-container-responsive">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>n°</th>
      <th>client</th>
      <th>date</th>
      <th>site</th>
			<th>status</td>
    </tr>
    @foreach ($orders as $order)
    <tr>
      <td>{{ $order->id_reserve_room }}</td>
      <td style="max-width: 200px;" class="ellipsis" title="{{ $order->command_number }}"><b><a href="{{ route('order.show_admin', $order->id_reserve_room) }}">{{ $order->command_number }}</a></b></td>
    	<td>{{ $order->client_name }} {{ $order->client_surname }}</td>
      <td>{{ date('d/m/Y', strtotime($order->date_start)) }}</td>
      <td>{{ $order->site_name }}</td>

			<td>{!! Html::badge_reserve($order->is_deleted, $order->date_end) !!}</td>

    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucune réservation.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
		{{ $links }}
	</div>
</div>

@endsection
