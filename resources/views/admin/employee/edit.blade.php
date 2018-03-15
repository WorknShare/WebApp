@extends('layouts.backoffice')

@section('title')
Modifier un employé
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $employee->surname . ' ' . $employee->name }} @endslot
	  @slot('description')Modifier un employé @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('employee.index') }}"><i class="fa fa-map-marker"></i> Employés</a></li>
	<li><a href="{{ route('employee.show', $employee->id_employee) }}"> {{ $employee->surname . ' ' . $employee->name }}</a></li>
	<li class="active">Modifier</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('employee.update', $employee->id_employee) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('put') }}
	        	<div class="box-body">
	        		{!! Form::controlWithIcon('email', 'email', $errors, $employee->email, 'Email', 'glyphicon-envelope', 'Email', ["maxlength" => '255', "required" => "required"]) !!}
	        		{!! Form::controlWithIcon('text', 'surname', $errors, $employee->surname, 'Prénom', 'glyphicon-user', 'Prénom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'name', $errors, $employee->name, 'Nom', 'glyphicon-user', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'address', $errors, $employee->address, 'Adresse', 'glyphicon-map-marker', 'Adresse', ["maxlength" => '255', "required" => "required"]) !!}
		            <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
	                	<label>Téléphone</label>

	                  	<input class="form-control" pattern="^(\d{2}\s?){5}$" type="text" name="phone" value="{{ $employee->phone }}" placeholder="Téléphone">
	                  	<span class="glyphicon glyphicon-phone form-control-feedback"></span>
	                	@if($errors->has('phone'))
	                	<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
	                	@endif
	              	</div>
	              	@if(Auth::user()->role == 1)
       				<div class="form-group has-feedback {{ $errors->has('role') ? 'has-error' : '' }}">
       					<label>Rôle</label>

	       				<select class="form-control" required name="role" autocomplete="off">
							<option value="1" {{ $employee->role == 1 ? 'selected' : '' }}> Administrateur</option>
							<option value="2" {{ $employee->role == 2 ? 'selected' : '' }}> Gestionnaire</option>
							<option value="3" {{ $employee->role == 3 ? 'selected' : '' }}> Responsable client</option>
	                  	</select>
	                  	@if($errors->has('role'))
	                	<span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
	                	@endif
       				</div>
       				@endif
	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
		          <a href="{{ route('employee.edit_password', $employee->id_employee) }}" class="btn btn-primary pull-right mr-xs-10"><i class="fa fa-lock"></i> <span class="hidden-xs">Modifier le mot de passe</span></a>
		          <a class="btn btn-default pull-left" href='{{ route('employee.show', $employee->id_employee) }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection