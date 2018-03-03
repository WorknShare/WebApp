@extends('layouts.backoffice')

@section('title')
Créer un forfait
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Forfaits @endslot
	  @slot('description')Créer un forfait @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('plan.index') }}"><i class="fa fa-map-marker"></i> Forfaits</a></li>
	<li class="active">Créer un forfait</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('plan.store') }}" method="post">
				{{ csrf_field() }}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, old('name'), 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'description', $errors, old('description'), 'Description', 'glyphicon-list-alt', 'Description', ["maxlength" => '255', "required" => "required"]) !!}
		            <div class="row">
		            	<div class="col-xs-12">
		            		<h4>Avantages</h4>
		            	</div>
		            	@foreach($advantages as $advantage)
		            	<div class="col-xs-6 col-sm-3 col-md-2" title="{{ $advantage->description }}">
				        	{!! Form::iCheckbox('advantages[]', $advantage->description, $errors, false, $advantage->id_plan_advantage) !!}
				    	</div>
				        @endforeach
				    </div>
	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Créer</button>
		          <a class="btn btn-default pull-left" href='{{ route('plan.index') }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection
