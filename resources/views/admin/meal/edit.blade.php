@extends('layouts.backoffice')

@section('title')
Modifier un repas
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $meal->name }} @endslot
	  @slot('description')Modifier un repas @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Repas</a></li>
	<li><a href="{{ route('site.show', $meal->id_meal) }}">{{ $meal->name }}</a></li>
	<li class="active">Modifier</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			{!! Form::model($meal, ['route' => ['meal.update', $meal->id_meal], 'method' => 'put']) !!}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, $meal->name, 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('number', 'price', $errors, $meal->price, 'price', 'glyphicon-euro', 'prix', ["step" => '0.01', "required" => "required" ]) !!}
		            {!! Form::control('textarea', 'menu', $errors, $meal->menu, 'Menu', 'Menu') !!}
		      	</div>

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
		          <a class="btn btn-default pull-left" href='{{ route('meal.show', $meal->id_meal) }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection
