@extends('layouts.frontoffice')

@section('title')
	{{ $site->name }}
@endsection

@section('css')
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">

	<style media="screen">
		.point-cursor{
			cursor: pointer;
		}
		.box.box-solid{
			padding: 5px;
		}


	</style>

@endsection

@section('page_title')
	@component('components.header')
		@slot('title')Réservation @endslot
			@slot('description') choisissez une salle @endslot
		@endcomponent
@endsection


@section('content')
	@if (count($rooms))
		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="box box-solid">
						<div class="col-xs-12">
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
					<div class="box box-solid" id="orderBox">
						<div class="col-xs-12 col-md-6 displayBlock" style="display: none">
							<div class="box-header with-border">
								<h4>Réservation</h4>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<form action="{{ route('order.store') }}" method="post" id="orderForm">
											<input type="hidden" name="id_client" value="{{ $user->id_client }}"></input>
											<input type="hidden" name="id_room" id="id_room"></input>
											{{ csrf_field() }}
											<div class="box-body">
												<div class='input-group date' id='datepicker'>
													<input id="date" type='text' class="form-control" name="date"/>
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
												<div class="col-xs-12 col-sm-6">
													{!! Form::timePicker('hour_start', $errors, 'Début :') !!}
												</div>
												<div class="col-xs-12 col-sm-6">
													{!! Form::timePicker('hour_end', $errors, 'Fin :') !!}
												</div>
												<label for="type">équipement</label>
												<div class="row">
													<div class="col-xs-12 col-sm-5">
														<select  id='type' name="id_room_type" class="form-control">
															<option value="" disabled selected>choisir</option>
															@foreach(App\EquipmentType::where("is_deleted", "=", 0)->get() as $roomEquipment)
																<option value="{{ $roomEquipment->id_equipment_type }}" {{$roomEquipment->id_equipment_type == old('id_room_type') ? 'selected' : ''}}>{{ $roomEquipment->name }}</option>
															@endforeach
														</select>
													</div>
													<div class="col-xs-12 col-sm-5 equipmentContainer" style="display : none">
														<select  id='equipment' name="id_equipment" class="form-control">
														</select>
													</div>
													<div class=" col-xs-6 col-sm-2 equipmentContainer" style="display : none">
														<button type="button" style="margin-top : 7px" onclick="addEquipment()" class="btn btn-sm btn-dark pull-right">Ajouter</button>
													</div>
												</div>
											</div>
											<div style="margin-top : 10px" class="box-footer">
												<button type="submit" class="btn btn-gradient btn--alien pull-right"><i class="fa fa-check"></i> Créer</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12" id="information">
							<div class="box-header with-border">
								<h4>Réservation</h4>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<center> Veuillez selectionner une salle </center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box box-solid">
						<div class="col-xs-12 col-md-6 displayBlock" style="display: none">
							<div class="box-header with-border">
								<h4>Les équipements ajoutés</h4>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-xs-12">
										<div class="box-body no-padding table-container-responsive">
											<table class="table table-striped" id="arrayEquipment">
												<tr>
											    <th>équipement</th>
											    <th>type</th>
													<th></th>
										  </tr>
											</table>
										</div>

										<div id="empty">
											<center> Aucun équipement n'a été ajouté.</center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
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
									<center>Veuillez selectionner une salle.<center>
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
			<a style="margin-top : 60px" class="btn btn-default pull-left" href='{{ route('order.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		</div>
	</div>
@endsection

@section('scripts')

	<script type="text/javascript" src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/moment/moment.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/locale-all.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/order.js') }}"></script>
	<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
	@include('order.js')

@endsection
