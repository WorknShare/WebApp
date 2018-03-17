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
	<li class="active">Modifier le mot de passe</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('employee.update_password', $employee->id_employee) }}" method="post">
				<div class="box-body">
			        {{ csrf_field() }}
			        @if(Auth::user()->role != 1 || Auth::user()->id_employee == $employee->id_employee)
			        {!! Form::controlWithIcon('password', 'oldPassword', $errors, '', 'Mot de passe actuel', 'glyphicon-lock', '', ["required" => "required"]) !!}
			        @endif
			        {!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock', '', ["required" => "required"]) !!}
			        {!! Form::controlWithIcon('password', 'password_confirmation', $errors, '', 'Confirmation du mot de passe', 'glyphicon-log-in', '', ["required" => "required"]) !!}
			        <div class="box-footer">
			        	<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Envoyer</button>
			         	<a class="btn btn-default pull-left" href='{{ route('employee.edit', $employee->id_employee) }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
			        </div>
		    	</div>
		    </form>
		</div>
	</div>
</div>
@endsection