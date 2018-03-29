@extends('layouts.frontoffice')

@section('title')
Historique
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Historique @endslot
	  @slot('description')les réservations @endslot
	@endcomponent
@endsection

@section('content')
  <div style="margin-bottom : 25px" class="row">
  	<div class="col-xs-12 col-md-6">
  		<div class="box box-solid">
  			<div class="box-header with-border">
  				<h3 class="box-title overflow-break-word" style="width:100%">Commande n°{{ $order->command_number }}</h3>
  			</div>
  			<div class="box-body">
  				<div class="row">
            <div class="col-xs-12">
  						<div class="row">
  							<div class="col-xs-12 col-sm-3 col-md-6 overflow-break-word">
  	  						<b>Site :</b> {{ $order->site_name }}
  	  					</div>
  							<div class="col-xs-12 col-sm-3 col-md-6 overflow-break-word">
  	  						<b>Salle :</b> {{ $order->room_name }}
  	  					</div>
  						</div>
  						<div class="row" style="margin-top : 15px">
  							<div style="margin-bottom : 10px" class="col-xs-12 col-sm-3 col-md-12">
  	  						<span><b>Date</b></span> {{date('d M Y', strtotime($order->date_start))}}
  	  					</div>
  							<div class="col-xs-12 col-sm-3  col-md-6">
  	  						<span><b>heure de début :</b></span> {{date('H:i', strtotime($order->date_start))}}
  	  					</div>
  	            <div class="col-xs-12 col-sm-3  col-md-6">
  	  						<span><b>heure de fin :</b></span> {{date('H:i', strtotime($order->date_end))}}
  	  					</div>
  						</div>
            </div>
  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="col-xs-12 col-md-6">
  		<div class="box box-solid">
  			<div class="box-header with-border">
  				<h4>Les équipements ajoutés ({{count($equipments)}})</h4>
  			</div>
  			<div class="box-body">
  				<div class="row">
  					<div class="col-xs-12">
              <div class="box-body no-padding">
                <table class="table">
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
  			@if(Auth::user()->role <= 3 && Auth::user()->role > 0)
  				{{ Form::open(['method' => 'DELETE', 'route' => ['order.destroy_admin', $order->id_reserve_room]]) }}
  				<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
  				{{ Form::close() }}
  			@endif
  			<a class="btn btn-default pull-left" href='{{ route('order.history') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
  		</div>
  	</div>
@endsection


@section('scripts')
  <script type="text/javascript">
    $('.submitDeleteReserve').click(function() {
      if(confirm('Voulez-vous annuler cette commande ?'))
      $(this).parent().submit();
    });
  </script>
@endsection
