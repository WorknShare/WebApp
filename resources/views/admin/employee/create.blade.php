@extends('layouts.backoffice')

@section('title')
Créer un employé
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Employés @endslot
	  @slot('description')Créer un employé @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('employee.index') }}"><i class="fa fa-map-marker"></i> Employés</a></li>
	<li class="active">Créer un employé</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('employee.store') }}" method="post">
				{{ csrf_field() }}
	        	<div class="box-body">
	        		{!! Form::controlWithIcon('email', 'email', $errors, old('email'), 'Email', 'glyphicon-envelope', 'Email', ["maxlength" => '255', "required" => "required"]) !!}
	        		{!! Form::controlWithIcon('text', 'surname', $errors, old('surname'), 'Prénom', 'glyphicon-user', 'Prénom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'name', $errors, old('name'), 'Nom', 'glyphicon-user', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'address', $errors, old('address'), 'Adresse', 'glyphicon-map-marker', 'Adresse', ["maxlength" => '255', "required" => "required"]) !!}
		            <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
	                	<label>Téléphone</label>

	                  	<input class="form-control" pattern="^(\d{2}\s?){5}$" type="text" name="phone" value="{{ old('phone') }}" placeholder="Téléphone">
	                  	<span class="glyphicon glyphicon-phone form-control-feedback"></span>
	                	@if($errors->has('phone'))
	                	<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
	                	@endif
	              	</div>
	              	{!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock', 'Mot de passe', ["required" => "required"]) !!}
       				{!! Form::controlWithIcon('password', 'password_confirmation', $errors, '', 'Confirmation du mot de passe', 'glyphicon-log-in', 'Confirmation du mot de passe', ["required" => "required"]) !!}
       				<div class="form-group has-feedback {{ $errors->has('role') ? 'has-error' : '' }}">
       					<label>Rôle</label>

	       				<select class="form-control" required name="role">
							<option value="1"> Administrateur</option>
							<option value="2"> Gestionnaire</option>
							<option value="3"> Manager</option>
	                  	</select>
	                  	@if($errors->has('role'))
	                	<span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
	                	@endif
       				</div>
	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Créer</button>
		          <a class="btn btn-default pull-left" href='{{ route('employee.index') }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection