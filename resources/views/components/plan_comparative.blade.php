<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">Forfaits</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding text-center">
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
            @foreach($planAdvantages as $planAdvantage)
            <tr>
              <td><b>{{ $planAdvantage->description }}</b></td>
              @foreach($plans as $plan)
              <td><i class="fa {{ planHasAdvantage($plan, $planAdvantage->id_plan_advantage) ? 'fa-check-circle text-success' : 'fa-times-circle text-muted' }} comparative-icon"></i></td>
              @endforeach
            </tr>
            @endforeach
            <tr>
              <td></td>
              @foreach($plans as $plan)
              <td><span class="price-tag">{{ $plan->price }}€</span><span class="text-muted price-tag-info">/mois</span></td>
              @endforeach
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>