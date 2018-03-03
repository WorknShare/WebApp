@extends('layouts.backoffice')

@section('title')
{{ $site->name }}
@endsection

@section('css')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Sites @endslot
	  @slot('description') @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li class="active">{{ $site->name }}</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
	        	<h3 class="box-title overflow-break-word" style="width:100%">{{ $site->name }}</h3>
	        </div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12 col-sm-5 col-md-4 overflow-break-word">
						<b>Adresse :</b> {{ $site->address }}
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3">
						<span><b>Wifi :</b></span> {!! Html::badge($site->wifi) !!}
					</div>
					<div class="col-xs-12 col-sm-3  col-md-3">
						<span><b>Boissons :</b></span> {!! Html::badge($site->drink) !!}
					</div>
					<div class="col-xs-12 col-sm-1 col-md-2">
						<a href="{{ route('site.edit', $site->id_site) }}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> <span class="hidden-sm">Modifier</span></a>
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
        		<h4>Horaires</h4>
        	</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						@if(!count($schedules))
							<p class="text-muted">Il n'y a aucun horaire pour l'instant.</p>
						@else
							<div class="box-body no-padding">
								<table class="table table-striped">
								    <tr>
								      <th>Jour</th>
								      <th>Ouverture</th>
								      <th>Fermeture</th>
								      <th></th>
								    </tr>
								    @foreach ($schedules as $schedule)
								    <tr>
								    	<td>{{ getDay($schedule->day) }}</td>
								    	<td>{{ date('H:i', strtotime($schedule->hour_opening)) }}</td>
								    	<td>{{ date('H:i', strtotime($schedule->hour_closing)) }}</td>
								    	<td>
								    		{{ Form::open(['method' => 'DELETE', 'route' => ['schedule.destroy', $schedule->id_schedule]]) }}
												<a class="text-danger submitDeleteSchedule point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
											{{ Form::close() }}
								    	</td>
								    </tr>
									@endforeach
							  </table>
							</div>
						@endif
						<div class="row">
							<div class="col-xs-12 bottom-controls">
								<a id="addScheduleButton" data-toggle="collapse" href="#addSchedulePane" class="btn btn-primary btn-xs pull-right">Ajouter un horaire</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 {{ count($errors->all()) ? '' : 'collapse'}}" id="addSchedulePane">
						<div class="col-xs-12">
							<h5>Ajouter un horaire</h5>
						</div>
						<form action="{{ route('schedule.store') }}" method="post">
							{{ csrf_field() }}
							<input type="hidden" value="{{ $site->id_site }}" name="id_site">
							<div class="col-xs-12 col-sm-6 form-group content-vertical {{ $errors->has('day') ? 'has-error' : '' }}">
								{!! $errors->first('day', '<span class="help-block"><strong>:message</strong></span>') !!}
								@for($i = 0; $i < 6; $i++)
									<label>
				                		<input type="radio" name="day" class="minimal" value="{{ $i }}" {{ $i == 0 || old('day') == $i ? 'checked' : '' }}> {{ getDay($i) }}
				                	</label>
								@endfor
			              	</div>
			              	<div class="col-xs-12 col-sm-6">
			              		{!! Form::timePicker('hour_opening', $errors, 'Ouverture :') !!}
					        </div>
					        <div class="col-xs-12 col-sm-6">
					            {!! Form::timePicker('hour_closing', $errors, 'Fermeture :') !!}
			              	</div>
			              	<div class="col-xs-12">
			              		<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Ajouter</button>
			              	</div>
			            </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4>Repas</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		{{ Form::open(['method' => 'DELETE', 'route' => ['site.destroy', $site->id_site]]) }}
			<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce site ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
		{{ Form::close() }}
		<a class="btn btn-default pull-left" href='{{ route('site.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
    </div>
</div>
@endsection

@section('scripts')
{!! iCheckRadioScript() !!}
<!-- bootstrap time picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
	$(function() {
		//Timepicker
	    $('#hour_opening').timepicker({
	    	minuteStep: 1,
	      	showInputs: false,
	    	showSeconds: false,
        	showMeridian: false,
        	defaultTime: {!! empty(old('hour_opening')) ? '"8:00"' : '"'.old('hour_opening').'"' !!},
	    })

      	$('#hour_opening').timepicker().on('changeTime.timepicker', function(e) {
        	var closingHour = $('#hour_closing').data('timepicker').hour;
        	var closingMinute = $('#hour_closing').data('timepicker').minute;
        	if(e.time.hours > closingHour || (e.time.hours >= closingHour && e.time.minutes >= closingMinute)) {

        		if(closingMinute == 0) {
        			closingHour--;
        			closingMinute = 59;
        		} else if(closingMinute == e.time.minutes) {
        			closingMinute--;
        		}

        		$('#hour_opening').timepicker('setTime', closingHour + ':' + closingMinute);
        	}
     	});

		$('#hour_closing').timepicker({
	    	minuteStep: 1,
	      	showInputs: false,
	    	showSeconds: false,
        	showMeridian: false,
        	defaultTime: {!! empty(old('hour_closing')) ? '"19:00"' : '"'.old('hour_closing').'"' !!},
	    })

	    $('#hour_closing').timepicker().on('changeTime.timepicker', function(e) {
        	var openingHour = $('#hour_opening').data('timepicker').hour;
        	var openingMinute = $('#hour_opening').data('timepicker').minute;
        	if(e.time.hours < openingHour || (e.time.hours == openingHour && e.time.minutes <= openingMinute)) {

        		if(openingMinute == 59) {
        			openingHour++;
        			openingMinute = 0;
        		} else if(openingMinute == e.time.minutes) {
        			openingMinute++;
        		}


        		$('#hour_closing').timepicker('setTime', openingHour + ':' + openingMinute);
        	}
     	});

     	//Submit delete schedule
     	$('.submitDeleteSchedule').click(function() {
     		if(confirm('Voulez-vous vraiment supprimer cet horaire ?'))
     			$(this).parent().submit();
     	});
	})
</script>
@endsection