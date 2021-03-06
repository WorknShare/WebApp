@extends('layouts.backoffice')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }} ">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }} ">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

<div class="row">
	<div class="col-md-4">
		<div class="box box-default">
		    <div class="box-header with-border">
		      <h3 class="box-title">Clients par forfait</h3>
		    </div>

		    <div class="box-body">
		      <div class="row">
		      	<span class="not-enough-data text-muted" id="planPieNotEnoughData">Données insuffisantes</span>
		        <div class="col-md-8">
		          <div class="chart-responsive">
		            <canvas id="plansPie" height="150" data-url="{{ route('admin.metrics.planspie') }}"></canvas>
		          </div>
		        </div>
		        <div class="col-md-4">
		          <ul class="chart-legend clearfix" id="plansPieLegend">
		          </ul>
		        </div>
		      </div>
		    </div>

		    <div class="box-footer">
		    	<button class="btn btn-info pull-right" id="refreshPlansPie"><i class="fa fa-refresh"></i> Rafraîchir</button>
		    </div> 
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-default">
		    <div class="box-header with-border">
		      <h3 class="box-title">Clients par forfait au cours du temps</h3>
		    </div>

		    <div class="box-body">
		      <div class="row">
		      	<span class="not-enough-data text-muted" id="planNotEnoughData">Données insuffisantes</span>
		        <div class="col-md-10">
		          <div class="chart-responsive">
		            <canvas id="plans" height="251" data-url="{{ route('admin.metrics.plans') }}"></canvas>
		          </div>
		        </div>
		        <div class="col-md-2">
		          <ul class="chart-legend clearfix" id="plansLegend">
		          </ul>
		        </div>
		      </div>
		    </div>

		    <div class="box-footer">
		    	<div>
					<div class="input-group">
						<input type="text" name="daterange" value="01/01/1900" class="form-control input-daterange" id="daterangePlans"/>
					</div>
				</div>
		    </div> 
		</div>
	</div>
	<div class="col-md-12">
		<div class="box box-default">
		    <div class="box-header with-border">
		      <h3 class="box-title">Nombre de réservations au cours du temps</h3>
		    </div>

		    <div class="box-body">
		      <div class="row">
		      	<span class="not-enough-data text-muted" id="reserveNotEnoughData">Données insuffisantes</span>
		        <div class="col-md-10">
		          <div class="chart-responsive">
		            <canvas id="reserve" height="251" data-url="{{ route('admin.metrics.reserve') }}"></canvas>
		          </div>
		        </div>
		        <div class="col-md-2">
		          <ul class="chart-legend clearfix" id="reserveLegend">
		          </ul>
		        </div>
		      </div>
		    </div>

		    <div class="box-footer">
		    	<div>
					<div class="input-group">
						<input type="text" name="daterange" value="01/01/1900" class="form-control input-daterange" id="daterangeReserve"/>
					</div>
				</div>
		    </div> 
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- ChartJS -->
<script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
