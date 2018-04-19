@extends('layouts.backoffice')

@section('title')
Employés
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Employés @endslot
	  @slot('description')Liste des employés @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Employés</li>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4 pull-right">
    <form action="{{ route('employee.index') }}" method="get" id="formSearch">
      <div class="form-group has-feedback">
        <input class="form-control " placeholder="Recherche" id="search" maxlength="255" name="search" type="text" value='{{ isset($_GET["search"]) ? $_GET["search"] : '' }}'>
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </form>
  </div>
</div>
@if(count($employees))

<div class="box-body no-padding table-container-responsive">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>Email</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Rôle</th>
    </tr>
    @foreach ($employees as $employee)
    <tr>
    	<td>{{ $employee->id_employee }}</td>
      <td><b><a href="{{ route('employee.show', $employee->id_employee) }}">{{ $employee->email }}</a></b></td>
      <td>{{ $employee->name }}</td>
      <td>{{ $employee->surname }}</td>
      <td>{{ backoffice_role($employee->role) }}</td>
    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucun employé.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
    @if(Auth::user()->role == 1)
    {{ link_to_route('employee.create', 'Ajouter un employé', [], ['class' => 'btn btn-primary pull-right']) }}
    @endif
		{{ $links }}
	</div>
</div>
@endsection
