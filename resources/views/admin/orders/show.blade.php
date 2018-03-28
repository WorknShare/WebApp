@extends('layouts.backoffice')

@section('title')
	{{ $order->command_number  }}
@endsection

@section('page_title')
	@component('components.header')
		@slot('title')Réservations @endslot
		@slot('description') @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('order.index_admin') }}">Réservations</a></li>
	<li class="active">{{ $order->command_number}}</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title overflow-break-word" style="width:100%">Commande n°{{ $order->command_number }}</h3>
			</div>
			<div class="box-body">
				<div class="row">
          <div class="col-xs-12">
            <div class="col-xs-12 col-sm-3 col-md-3 overflow-break-word">
  						<b>Client :</b> {{ $order->client_name }}
  					</div>
  					<div class="col-xs-12 col-sm-3 col-md-3">
  						<span><b>Date</b></span> {{date('d M Y', strtotime($order->date_start))}}
  					</div>
  					<div class="col-xs-12 col-sm-3  col-md-3">
  						<span><b>heure de début :</b></span> {{date('H:i', strtotime($order->date_start))}}
  					</div>
            <div class="col-xs-12 col-sm-3  col-md-3">
  						<span><b>heure de fin :</b></span> {{date('H:i', strtotime($order->date_end))}}
  					</div>
          </div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4>Les équipements ajoutés ({{count($equipments)}})</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>type</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($equipments as $equipment)
                    <tr>
                      <td>{{$equipment->serial_number}}</td>
                      <td>{{$equipment->name}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<div class="row">
		<div class="col-xs-12">
			<a class="btn btn-default pull-left" href='{{ route('order.index_admin') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		</div>
	</div>
@endsection
