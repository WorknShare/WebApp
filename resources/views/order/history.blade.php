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
  @if(count($orders))
  <div class="box-body no-padding table-container-responsive">
    <table class="table">
      <tr>
        <th>n°</th>
        <th>site</th>
        <th>salle</th>
        <th>date</th>
        <th>heure de début</th>
        <th>Heure de fin</th>
        <th>status</th>
        <th style="width: 40px"></th>
      </tr>
      @foreach ($orders as $order)
      <tr>
        <td style="max-width: 200px;" class="ellipsis" title="{{ $order->command_number}}"><b><a href="{{ route('order.show', $order->id_reserve_room) }}">{{ $order->command_number }}</a></b></td>
        <td>{{ $order->site_name }}</td>
        <td>{{ $order->room_name }}</td>
        <td>{{ date('d/m/Y', strtotime($order->date_start)) }}</td>
        <td>{{ date('H:i', strtotime($order->date_start)) }}</td>
        <td>{{ date('H:i', strtotime($order->date_end)) }}</td>
  			<td>{!! Html::badge_reserve($order->is_deleted, $order->date_end) !!}</td>
        <?php
          $now = new DateTime('now');
          $date = new DateTime($order->date_start);
         ?>
          <td>
            @if($now < $date && $order->is_deleted == 0)
              {{ Form::open(['method' => 'DELETE', 'route' => ['order.destroy', $order->id_reserve_room]]) }}
              <a style="cursor: pointer" class="text-danger submitDeleteReserve point-cursor" value="Supprimer" type="submit"><i class="fa fa-ban"></i></a>
              {{ Form::close() }}
            @endif
        </td>

      </tr>
  	@endforeach
    </table>
  </div>
  @else
  <div class="row">
  	<div class="col-xs-12">
  		<h4 class="text-muted">Vous n'avez réalisé aucune réservation</h4>
  	</div>
  </div>
  @endif

  <div class="row bottom-controls">
  	<div class="col-xs-12">
  		{{ $links }}
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
