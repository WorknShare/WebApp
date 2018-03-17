@extends('layouts.backoffice')

@section('title')
Modifier un forfait
@endsection

@section('page_title')
	@component('components.header')
		@slot('title'){{ $plan->name }} @endslot
		@slot('description')Modifier un forfait @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('plan.index') }}"><i class="fa fa-map-marker"></i> Forfaits</a></li>
	<li><a href="{{ route('plan.show', $plan->id_plan) }}">{{ $plan->name }}</a></li>
	<li class="active">Modifier</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			{!! Form::model($plan, ['route' => ['plan.update', $plan->id_plan], 'method' => 'put']) !!}
				{{ csrf_field() }}
				<div class="box-body">
					{!! Form::controlWithIcon('text', 'name', $errors, $plan->name, 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
					{!! Form::controlWithIcon('text', 'description', $errors, $plan->description, 'Description', 'glyphicon-list-alt', 'Description', ["maxlength" => '255', "required" => "required"]) !!}
					{!! Form::controlWithIcon('number', 'price', $errors, $plan->price, 'Prix', 'glyphicon-euro', 'Prix', ["step" => '0.01', "min" => "0", "required" => "required"]) !!}
					{!! Form::control('textarea', 'notes', $errors, $plan->notes, 'Informations complémentaires', 'Informations complémentaires') !!}
					<div class="row {{ $errors->has('advantages') ? 'has-error' : '' }}">
						<div class="col-xs-12">
							<h4>Avantages</h4>
							@if($errors->has('advantages'))
							<span class="help-block"><strong>{{ $errors->first('advantages') }}</strong></span>
							@endif
						</div>

						<div class="col-xs-6 col-sm-3 col-md-2" title="Réserver des salles et du matériel">
							{!! Form::iCheckbox('reserve', 'Réserver des salles et du matériel', $errors, $plan->reserve) !!}
						</div>
						<div class="col-xs-6 col-sm-3 col-md-2" title="Commander des plateaux repas">
							{!! Form::iCheckbox('order_meal', 'Commander des plateaux repas', $errors, $plan->order_meal) !!}
						</div>

						@foreach($advantages as $advantage)
						<div class="col-xs-6 col-sm-3 col-md-2" title="{{ $advantage->description }}">
							{!! Form::iCheckbox('advantages[]', $advantage->description, $errors, in_array($advantage->id_plan_advantage, $plan_advantages), $advantage->id_plan_advantage) !!}
						</div>
						@endforeach
					</div>
				</div>

				<div class="box-footer">
					<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
					<a class="btn btn-default pull-left" href='{{ route('plan.show', $plan->id_plan) }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection
