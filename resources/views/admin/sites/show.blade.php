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
					@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
						<div class="col-xs-12 col-sm-1 col-md-2">
							<a href="{{ route('site.edit', $site->id_site) }}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> <span class="hidden-sm">Modifier</span></a>
						</div>
					@endif
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
										@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
										<th></th>
										@endif
									</tr>
									@foreach ($schedules as $schedule)
										<tr>
											<td>{{ getDay($schedule->day) }}</td>
											<td>{{ date('H:i', strtotime($schedule->hour_opening)) }}</td>
											<td>{{ date('H:i', strtotime($schedule->hour_closing)) }}</td>
											@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
											<td>
												{{ Form::open(['method' => 'DELETE', 'route' => ['schedule.destroy', $schedule->id_schedule]]) }}
												<a class="text-danger submitDeleteSchedule point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
												{{ Form::close() }}
											</td>
											@endif
										</tr>
									@endforeach
								</table>
							</div>
						@endif
						@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
							<div class="row">
								<div class="col-xs-12 bottom-controls">
									<a id="addScheduleButton" data-toggle="collapse" href="#addSchedulePane" class="btn btn-primary btn-xs pull-right">Ajouter un horaire</a>
								</div>
							</div>
						@endif
					</div>
					@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
						<div class="col-xs-12 {{ $errors->has('day') || $errors->has('hour_opening') || $errors->has('hour_closing') ? '' : 'collapse'}}" id="addSchedulePane">
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
					@endif
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
						<?php $mealCount = \App\Meal::where('is_deleted', '=', 0)->count(); ?>
						@if($mealCount <= 0)
						<div class="alert alert-info alert-dismissible"><i class="fa fa-info-circle"></i><b class="overflow-break-word">Vous devez <a href="{{ route('meal.index') }}">créer au moins un repas</a> avant de pouvoir ajouter des repas.</b></div>
						@endif
						@if(!count($meals))
							<p class="text-muted">Il n'y a aucun repas pour l'instant.</p>
						@else
							<div class="box-body no-padding">
								<table class="table table-striped">
									<tr>
										<th>Repas</th>
										<th>Prix</th>
										@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
										<th></th>
										@endif
									</tr>
									@foreach ($meals as $meal)
										<tr>
											<td><a href="{{ route('meal.show', $meal->id_meal) }}">{{ $meal->name }}</a></td>
											<td>{{ $meal->price }}€</td>
											@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
											<td>
												{{ Form::open(['method' => 'PUT', 'route' => ['site.removemeal', $site->id_site]]) }}
												<input type="hidden" value="{{ $meal->id_meal }}" name="meal" required autocomplete="off">
												<a class="text-danger submitDeleteMeal point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
												{{ Form::close() }}
											</td>
											@endif
										</tr>
									@endforeach
								</table>
							</div>
						@endif
						@if(Auth::user()->role <= 2 && Auth::user()->role > 0 && $mealCount > 0)
							<div class="row">
								<div class="col-xs-12 bottom-controls">
									<a id="addMealButton" data-toggle="collapse" href="#addMealPane" class="btn btn-primary btn-xs pull-right">Ajouter un repas</a>
								</div>
							</div>
						@endif
					</div>
					@if(Auth::user()->role <= 2 && Auth::user()->role > 0 && $mealCount > 0)
						<div class="col-xs-12 {{ $errors->has('meal') ? '' : 'collapse'}}" id="addMealPane">
							<h5><b>Ajouter un repas</b></h5>
							<form action="{{ route('site.affectmeal', $site->id_site) }}" method="post">
								{{ csrf_field() }}
								{{ method_field('put') }}
								<div class="form-group">
									<select name="meal" class="form-control">
										@foreach(App\Meal::where("is_deleted", "=", 0)->get() as $meal)
										@if(!siteHasMeal($meals, $meal->id_meal))
											<option value="{{ $meal->id_meal }}">{{ $meal->name }}</option>
										@endif
										@endforeach
									</select>
								</div>
								<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Ajouter</button>
							</form>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4>Les salles</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						<?php $roomTypeCount = \App\RoomTypes::where('is_deleted', '=', 0)->count(); ?>
						@if($roomTypeCount <= 0)
						<div class="alert alert-info alert-dismissible"><i class="fa fa-info-circle"></i><b class="overflow-break-word">Vous devez <a href="{{ route('typeOfRooms.index') }}">créer au moins un type de salle</a> avant de pouvoir ajouter des salles.</b></div>
						@endif
						@if(!count($rooms))
							<p class="text-muted">Il n'y a aucune salle pour l'instant.</p>
						@else
							<div class="box-body no-padding">
								<table class="table table-striped">
									<tr>
										<th>Nom</th>
										<th>Type de salle</th>
										<th>Places maximum</th>
										<th style="width:30px"></th>
										@if ( Auth::user()->role <= 2 && Auth::user()->role > 0)
											<th style="width:30px"></th>
											<th style="width:30px"></th>
										@endif

									</tr>
									@foreach ($rooms as $room)
										<tr>
											<td>{{ $room->name }}</td>
											<td>{{ $room->room_type }}</td>
											<td>{{ $room->place }}</td>
											<td><a class="point-cursor" href="{{ route('room.show', $room->id_room) }}"><i class="fa fa-eye"></i></a></td>
											@if ( Auth::user()->role <= 2 && Auth::user()->role > 0)
												<td><a class="point-cursor" href="{{ route('room.edit', $room->id_room) }}"><i class="fa fa-pencil"></td>
												<td>
													{{ Form::open(['method' => 'DELETE', 'route' => ['room.destroy', $room->id_room]]) }}
													<a class="text-danger submitDeleteRoom point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
													{{ Form::close() }}
												</td>
											@endif
										</tr>
									@endforeach
								</table>
							</div>
						@endif
						@if(Auth::user()->role <= 2 && Auth::user()->role > 0 && $roomTypeCount > 0)
							<div class="row">
								<div class="col-xs-12 bottom-controls">
									<a id="addRoomButton" data-toggle="collapse" href="#addRoomPane" class="btn btn-primary btn-xs pull-right">Ajouter une salle</a>
								</div>
							</div>
						@endif
					</div>
					@if(Auth::user()->role <= 2 && Auth::user()->role > 0 && $roomTypeCount > 0)
						<div class="col-xs-12 {{ $errors->has('name') || $errors->has('place') || $errors->has('id_room_type') ? '' : 'collapse'}}" id="addRoomPane">
							<h5><b>Ajouter une salle</b></h5>
							<form action="{{ route('room.store') }}" method="post">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $site->id_site }}" name="id_site">
								{!! Form::control('text', 'name', $errors, old('name'), 'Nom', '', ["maxlength" => '255', "required" => "required"]) !!}
								{!! Form::control('number', 'place', $errors, old('place'), 'Nombre de places', '', ["min" => '1', 'step' => '1', "required" => "required"]) !!}
								<div class="form-group">
									<label class="control-label">Type de salle</label>
									<select name="id_room_type" class="form-control">
										@foreach(App\RoomTypes::where("is_deleted", "=", 0)->get() as $roomType)
											<option value="{{ $roomType->id_room_type }}">{{ $roomType->name }}</option>
										@endforeach
									</select>
								</div>
								<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Ajouter</button>
							</form>
						</div>
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
				{{ Form::open(['method' => 'DELETE', 'route' => ['site.destroy', $site->id_site]]) }}
				<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce site ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
				{{ Form::close() }}
			@endif
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
@endsection
