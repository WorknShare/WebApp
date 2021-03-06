@extends('layouts.backoffice')

@section('title')
{{ $plan->name }}
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Forfaits @endslot
	  @slot('description') @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('plan.index') }}"><i class="fa fa-credit-card"></i> Forfaits</a></li>
	<li class="active">{{ $plan->name }}</li>
@endsection

@section('content')

@if(!count($advantages) && !$plan->order_meal && !$plan->reserve)
<div class="alert alert-warning alert-dismissible"><i class="fa fa-excalamation-circle"></i><b class="overflow-break-word">Ce forfait n'a pas d'avantages !</b></div>
@endif

<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header with-border">
	        	<h3 class="box-title overflow-break-word" style="width:100%">{{ $plan->name }}</h3>
	        </div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12 col-sm-6 overflow-break-word">
						<b>Description :</b> {{ $plan->description }}
					</div>
					<div class="col-xs-12 col-sm-6 overflow-break-word">
						<b>Prix :</b> <span class="price-tag">{{ $plan->price }}€</span><span class="text-muted price-tag-info">/mois</span>
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
        		<h4>Avantages</h4>
        	</div>
			<div class="box-body">
				<div class="row">
					@if($plan->reserve)
					<div class="col-xs-6 col-md-4 ellipsis" title="Réserver des salles et du matériel">
						<i class="fa fa-check-circle text-success icon-check"></i> Réserver des salles et du matériel
					</div>
					@endif
					@if($plan->order_meal)
					<div class="col-xs-6 col-md-4 ellipsis" title="Commander des plateaux repas">
						<i class="fa fa-check-circle text-success icon-check"></i> Commander des plateaux repas
					</div>
					@endif
					@foreach($advantages as $advantage)
		            <div class="col-xs-6 col-md-4 ellipsis" title="{{ $advantage->description }}">
						<i class="fa fa-check-circle text-success icon-check"></i> {{ $advantage->description }}
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
        		<h4>Informations complémentaires</h4>
        	</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12  overflow-break-word">
					@if(!empty($plan->notes))
					{{ $plan->notes }}
					@else
					<span class="text-muted">Aucune information complémentaire</span>
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		@if(Auth::user()->role == 1)
		{{ Form::open(['method' => 'DELETE', 'route' => ['plan.destroy', $plan->id_plan]]) }}
			<button class="btn btn-danger pull-right" value="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce forfait ?')" type="submit"><i class="fa fa-trash"></i> Supprimer</button>
		{{ Form::close() }}
		<a href="{{ route('plan.edit', $plan->id_plan) }}" class="btn btn-primary pull-right" style="margin-right: 5px"><i class="fa fa-pencil"></i> Modifier</a>
		@endif
		<a class="btn btn-default pull-left" href='{{ route('plan.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
    </div>
</div>
@endsection