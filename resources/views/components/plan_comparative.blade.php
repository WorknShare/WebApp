<?php
$showedOrderMeal = false;
$showedReserve = false;
?>

<div class="row">
  <div class="col-xs-12">
      <div class="table-responsive no-padding text-center">
        <table class="table comparative-table">
          <tbody>
            <tr>
              <th></th>
              @foreach($plans as $plan)
              <th class="text-center comparative-header">{{ $plan->name }}</th>
              @endforeach
            </tr>
            <tr>
              <td></td>
              @foreach($plans as $plan)
              <td class="comparative-description overflow-break-word">{{ $plan->description }}</td>
              @endforeach
            </tr>
            <tr>
              <td></td>
              @foreach($plans as $plan)
              <td class="text-muted comparative-description overflow-break-word">{{ $plan->notes }}</td>
              @endforeach
            </tr>
            @foreach($planAdvantages as $planAdvantage)
            @if($reserveCount >= $planAdvantage->plans_count && !$showedReserve)
            <tr>
              <td><b>Réserver des salles et du matériel</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ $plan->reserve ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            <?php $showedReserve = true; ?>
            @endif
            @if($orderMealCount >= $planAdvantage->plans_count && !$showedOrderMeal)
            <tr>
              <td><b>Commander des plateaux repas</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ $plan->order_meal ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            <?php $showedOrderMeal = true; ?>
            @endif
            <tr>
              <td><b>{{ $planAdvantage->description }}</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ planHasAdvantage($plan, $planAdvantage->id_plan_advantage) ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            @endforeach
            @if(!$showedReserve)
            <tr>
              <td><b>Réserver des salles et du matériel</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ $plan->reserve ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            @endif
            @if(!$showedOrderMeal)
            <tr>
              <td><b>Commander des plateaux repas</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ $plan->order_meal ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            @endif
            <tr>
              <td></td>
              @foreach($plans as $plan)
              <td><span class="price-tag">{{ $plan->price }}€</span><span class="text-muted price-tag-info">/mois TTC</span></td>
              @endforeach
            </tr>
            @if(isset($showButtons) ? $showButtons : false)
            <tr>
              <td></td>
              @foreach($plans as $plan)
              @if($plan->id_plan != Auth::user()->id_plan)
                <td><a class="btn btn-block btn-primary btn-lg" href='{{ route('plan.payment', $plan->id_plan) }}'> Choisir !</a></td>
              @else
                <td><a class="btn btn-block btn-primary btn-lg" href='{{ route('plan.payment', $plan->id_plan) }}'> Renouveler</a></td>
              @endif
              @endforeach
            </tr>
            @endif
          </tbody>
        </table>
      </div>
  </div>
</div>