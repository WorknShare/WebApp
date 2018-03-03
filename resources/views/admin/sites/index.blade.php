@extends('layouts.backoffice')

@section('title')
Sites
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Sites @endslot
	  @slot('description')Liste des sites @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Sites</li>
@endsection

@section('content')

<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4 pull-right">
    <form action="{{ route('site.index') }}" method="get" id="formSearch">
      <div class="form-group has-feedback">
        <input class="form-control " placeholder="Recherche" id="search" maxlength="255" name="search" type="text" value='{{ isset($_GET["search"]) ? $_GET["search"] : '' }}'>
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </form>
  </div>
</div>
@if(count($sites))

<div class="box-body no-padding table-container-responsive">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>Nom</th>
      <th>Adresse</th>
      <th style="width: 40px">Wifi</th>
      <th style="width: 40px">Boissons</th>
    </tr>
    @foreach ($sites as $site)
    <tr>
    	<td>{{ $site->id_site }}</td>
      <td style="max-width: 200px;" class="ellipsis" title="{{ $site->name }}"><b><a href="{{ route('site.show', $site->id_site) }}">{{ $site->name }}</a></b></td>
      <td>{{ $site->address }}</td>
      <td>{!! Html::badge($site->wifi) !!}</td>
      <td>{!! Html::badge($site->drink) !!}</td>
    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucun site.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
		{{ link_to_route('site.create', 'Ajouter un site', [], ['class' => 'btn btn-primary pull-right']) }}
		{{ $links }}
	</div>
</div>

@endsection
