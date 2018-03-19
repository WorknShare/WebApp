@extends('layouts.backoffice')

@section('title')
{{ $type->name }} ({{ $equipment->serial_number }})
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Matériel @endslot
	  @slot('description'){{ $type->name }} @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('equipmenttype.index') }}"><i class="fa fa-laptop"></i> Types de matériel</a></li>
	<li><a href="{{ route('equipmenttype.show', $type->id_equipment_type) }}">{{ $type->name }}</a></li>
	<li class="active">{{ $equipment->serial_number }}</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
	        	<h3 class="box-title overflow-break-word" style="width:100%">{{ $equipment->serial_number }}</h3>
	        </div>
			<div class="box-body">
				<div class="col-xs-12 col-sm-9">
					@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
					<form class="form-horizontal" id="formChangeAffect" action="{{ route('equipmenttype.equipment.affect', ['equipmenttype' => $type->id_equipment_type , 'equipment' => $equipment->id_equipment]) }}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group" style="margin-bottom:0">
							<label class="control-label pull-left" style="padding-left:15px">Site affecté :</label> 
							<div class="col-sm-9">
								<select class="form-control" required name="site" autocomplete="off">
										<option value="0" {{ is_null($site) ? 'selected' : '' }}> Aucun</option>
									@foreach(App\Site::where('is_deleted','=',0)->get() as $site2)
					                    <option value="{{ $site2->id_site }}" {{ $siteId == $site2->id_site ? 'selected' : '' }}>{{ $site2->name }}</option>
				                    @endforeach
			                  	</select>
		                  	</div>
	                  	</div>
	                </form>
	                @else
	                <b>Site affecté :</b> {{ is_null($site) ? 'Aucun' : $site->name }}
	                @endif
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3">
					<span><b>État :</b></span> <span class="badge bg-green">OK</span> <!-- TODO not ok if has ticket -->
				</div>
			</div>
		</div>
	</div>		
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4>Réservations</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">
						Placeholder reservations
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<a class="btn btn-default pull-left" href='{{ route('equipmenttype.show', $type->id_equipment_type) }}'> <i class="fa fa-chevron-left"></i> Retour</a>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/equipment.js') }}"></script>
@endsection