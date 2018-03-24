@extends('layouts.backoffice')

@section('title')
	{{ $site->name }}
@endsection

@section('css')
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
@endsection

@section('page_title')
	@component('components.header')
		@slot('title')Sites @endslot
		@slot('description') @endslot
	@endcomponent
@endsection



@section('breadcrumb_nav')
	<li><a href="{{ route('myaccount.index') }}"><i class="fa fa-home"></i> Mon profil</a></li>
	<li><a href="{{ route('order.index') }}"><i class="fa fa-map-marker"></i>Choix du site</a></li>
	<li class="active"> {{ $site->name }}</li>
@endsection

@section('content')
@if (count($rooms))
  <div class="row">
  	<div class="col-xs-12 col-md-4">
  		<div class="box box-solid">
  			<div class="box-header with-border">
  				<h4>Les salles</h4>
  			</div>
  			<div class="box-body">
  				<div class="row">
  					<div class="col-xs-12">
              <div class="box-body no-padding table-container-responsive">
                <table class="table table-striped">
                  <tr>
                    <th>Nom</th>
                    <th>Type de salle</th>
                    <th>Nombre de personnes maximum</th>
                  </tr>
                  @foreach ($rooms as $room)
                  <tr>
                    <td style="max-width: 200px;" class="ellipsis" title="{{ $room->name }}"><b><a class="point-cursor" onclick="ajaxCalendar({{$room->id_room}})">{{ $room->name }}</a></b></td>
                    <td>{{ $room->room_type }}</td>
                    <td>{!! $room->place !!}</td>
                  </tr>
                @endforeach
                </table>
            </div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="col-xs-12 col-md-8">
  		<div class="box box-solid">
  			<div  class="box-header with-border">
          <div class="row">
            <div class="col-xs-6">
              <h4 style="display: inline-block">Les disponiblités</h4>
            </div>
            <div class="col-xs-6">
              <h4 id="nameRoom"></h4>
            </div>
          </div>
  			</div>
  			<div class="box-body">
  				<div class="row">
  					<div class="col-xs-12">
              <div id="container">
                  Veuillez selectionner une salle.
              </div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
@else
  <div class="row">
  	<div class="col-xs-12">
  		<h4 class="text-muted">Aucune salle de disponible. Veuillez choisir un autre site.</h4>
  	</div>
  </div>
@endif

	<div class="row">
		<div class="col-xs-12">
			<a class="btn btn-default pull-left" href='{{ route('order.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		</div>
	</div>
@endsection

@section('scripts')

  <script type="text/javascript" src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/moment/moment.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/locale-all.js') }}"></script>
  @include('order.calendarOrder')

	<!-- bootstrap time picker -->
  <!--
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

		//submit delete room
		$('.submitDeleteRoom').click(function() {
			if(confirm('Voulez-vous vraiment supprimer cette salle ?'))
			$(this).parent().submit();
		});

		//submit delete meal
		$('.submitDeleteMeal').click(function() {
			if(confirm('Voulez-vous vraiment retirer ce repas de ce site ?'))
			$(this).parent().submit();
		});
	})



</script>

-->
@endsection
