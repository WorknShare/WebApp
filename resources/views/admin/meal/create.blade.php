@extends('layouts.backoffice')

@section('title')
Créer un repas
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Repas @endslot
	  @slot('description')Créer un repas @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> repas</a></li>
	<li class="active">Créer un repas</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('meal.store') }}" method="post">
				{{ csrf_field() }}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, old('name'), 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
                 {!! Form::controlWithIcon('number', 'price', $errors, old('price'), 'Prix', 'glyphicon-euro', 'Prix', ["step" => '0.01', "min" => "0", "required" => "required"]) !!}		            <div class="row">
				        <textarea name="menu" class="form-control" maxlength="255" required>  </textarea>

	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Créer</button>
		          <a class="btn btn-default pull-left" href='{{ route('meal.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection
