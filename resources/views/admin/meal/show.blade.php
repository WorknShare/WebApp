@extends('layouts.backoffice')

@section('title')
	{{ $meal->name }}
@endsection

@section('page_title')
	@component('components.header')
		@slot('title')Repas @endslot
		@slot('description') @endslot
	@endcomponent
@endsection


@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('meal.index') }}"><i class="fa fa-apple"></i> Repas</a></li>
	<li class="active">{{ $meal->name }}</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title overflow-break-word" style="width:100%">{{ $meal->name }}</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12 col-sm-6 overflow-break-word">
							<b>Menu :</b><br><span style="white-space: pre-line;">{{ $meal->menu }}</span>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-4 overflow-break-word">
							<b>Prix :</b> <span class="price-tag">{{ $meal->price }}€</span>
						</div>
						@if(Auth::user()->role <= 2 && Auth::user()->role > 0)
							<div class="col-xs-12 col-sm-1 col-md-2">
								<a href="{{ route('meal.edit', $meal->id_meal) }}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> <span class="hidden-sm">Modifier</span></a>
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
				{{ Form::open(['method' => 'DELETE', 'route' => ['meal.destroy', $meal->id_meal]]) }}
				<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce repas ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
				{{ Form::close() }}
			@endif
			<a class="btn btn-default pull-left" href='{{ route('meal.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		</div>
	</div>
@endsection