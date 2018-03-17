@extends('layouts.backoffice')

@section('title')
{{ $employee->surname . ' ' . $employee->name }}
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Employés @endslot
	  @slot('description'){{ $employee->surname . ' ' . $employee->name }} @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Employés</a></li>
	<li class="active">{{ $employee->surname . ' ' . $employee->name }}</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
	        	<h3 class="box-title overflow-break-word" style="width:100%">{{ $employee->surname . ' ' . $employee->name }}</h3>
	        </div>
			<div class="box-body">
				<div class="row text-center overflow-break-word">
					<div class="col-xs-12">
						<h4><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp; <b>Adresse email :</b> {{ $employee->email }}</h4>
					</div>
				</div>
				<div class="row text-center overflow-break-word">
					<div class="col-xs-12">
						<h4><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; <b>Adresse :</b> {{ $employee->address }}</h4>
					</div>
				</div>
				@if(isset($employee->phone))
				<div class="row text-center overflow-break-word">
					<div class="col-xs-12">
						<h4><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <b>Téléphone :</b> {{ $employee->phone }}</h4>
					</div>
				</div>
				@endif
				<div class="row text-center overflow-break-word">
					<div class="col-xs-12">
						<h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp; <b>Rôle :</b> {{ backoffice_role($employee->role) }}</h4>
					</div>
				</div>
				<div class="row text-center overflow-break-word">
					<div class="col-xs-12">
						<h4><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; <b>Mot de passe modifié :</b> {!! Html::badge($employee->changed_password) !!}</h4>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>

<div class="row">
	<div class="col-xs-12">
		@if($employee->id_employee != Auth::user()->id_employee && Auth::user()->role == 1)
		{{ Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id_employee]]) }}
			<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
		{{ Form::close() }}
		@endif
		@if($employee->id_employee == Auth::user()->id_employee || Auth::user()->role == 1)
		<a href="{{ route('employee.edit', $employee->id_employee) }}" class="btn btn-primary pull-right {{ $employee->id_employee != Auth::user()->id_employee ? 'mr-xs-10' : ''}}"><i class="fa fa-pencil"></i> <span class="hidden-xs">Modifier</span></a>
		@endif
		<a class="btn btn-default pull-left" href='{{ route('employee.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
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