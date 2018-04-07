@if(count($orders))
  <div class="box-body no-padding table-container-responsive">
    <table class="table" id="orders_table">
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
            <td class="badge_is_deleted">{!! Html::badge_reserve($order->is_deleted, $order->date_end) !!}</td>
            <?php
            $now = new DateTime('now');
            $date = new DateTime($order->date_start);
            ?>
            <td class="delete_button">
              @if($now < $date && $order->is_deleted == 0)
                <span style='display : none'>{{$order->id_reserve_room}}</span>
                <a style="cursor: pointer" class="text-danger DeleteOrder point-cursor"><i class="fa fa-ban"></i></a>
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

<div class="row bottom-controls pull-right">
  <div id="link_order" class="col-xs-12">
    {{ $orders->links() }}
  </div>
</div>
