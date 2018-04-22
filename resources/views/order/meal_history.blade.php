@if(count($meals))
  <div class="box-body no-padding table-container-responsive">
    <table class="table" id="meals_table">
      <tr>
        <th>n°</th>
        <th>site</th>
        <th>Menu</th>
        <th>prix</th>
        <th>date</th>
        <th>heure</th>
        <th>status</th>
        <th style="width: 40px"></th>
      </tr>
      @foreach ($meals as $meal)
        <tr>
          <td style="max-width: 200px;" class="ellipsis" title="{{ $meal->command_number}}"><b>{{ $meal->command_number }}</b></td>
          <td>{{ $meal->site_name }}</td>
          <td>{{ $meal->meal_name }}</td>
          <td>{{ $meal->meal_price }}</td>
          <td>{{ date('d/m/Y', strtotime($meal->hour)) }}</td>
          <td>{{ date('H:i', strtotime($meal->hour)) }}</td>
          <td class="badge_is_deleted">{!! Html::badge_reserve($meal->is_deleted, $meal->hour) !!}</td>
          <?php
          $now = new DateTime('now');
          $date = new DateTime($meal->hour);
          ?>
          <td class="delete_button">
            @if($now < $date && $meal->is_deleted == 0)
              <span style='display : none'>{{$meal->id_order_meal}}</span>
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
      <h4 class="text-muted">Vous n'avez réalisé aucune commande</h4>
    </div>
  </div>
@endif

<div class="row bottom-controls pull-right">
  <div id="link_meal" class="col-xs-12">
    {{ $meals->links() }}
  </div>
</div>
