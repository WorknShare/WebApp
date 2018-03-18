@extends('layouts.backoffice')

@section('title')
Clients
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Clients @endslot
	  @slot('description')Liste des clients @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Clients</li>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4 pull-right">
    <form action="{{ route('user.index') }}" method="get" id="formSearch">
      <div class="form-group has-feedback">
        <input class="form-control " placeholder="Recherche" id="search" maxlength="255" name="search" type="text" value='{{ isset($_GET["search"]) ? $_GET["search"] : '' }}'>
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </form>
  </div>
</div>
@if(count($clients))

<div class="box-body no-padding table-container-responsive">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>Email</th>
      <th>Nom</th>
      <th>Prénom</th>
			<th>Compte actif</th>
			<th style="width:30px"></th>
			<th style="width:30px"></th>
    </tr>
    @foreach ($clients as $client)
    <tr>
    	<td>{{ $client->id_client }}</td>
      <td><b><a href="{{ route('user.edit_admin', $client->id_client) }}">{{ $client->email }}</a></b></td>
      <td>{{ $client->name }}</td>
      <td>{{ $client->surname }}</td>
			<td>{!! Html::badge(!$client->is_deleted) !!}</td>
			@if (!$client->is_deleted)
				<td><a class="point-cursor" href="{{ route('user.edit_admin', $client->id_client) }}"><i class="fa fa-pencil"></td>
				<td>
					{{ Form::open(['method' => 'DELETE', 'route' => ['user.ban', $client->id_client]]) }}
			 			<a value="ban" type="submit" class="submitBanUser point-cursor text-danger"><i class="fa fa-gavel"></i></a>
					{{ Form::close() }}
				</td>
			@else
				<td></td>
				<td>
					{{ Form::open(['method' => 'put', 'route' => ['user.unban', $client->id_client]]) }}
						<a value="unban" type="submit" class="submitUnbanUser point-cursor text-success"><i class="fa fa-gavel"></i></a>
					{{ Form::close() }}
				</td>
			@endif


    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucun client.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
		{{ $links }}
	</div>
</div>
@endsection


@section('scripts')

	<script type="text/javascript">
	$(function() {
		$('.submitBanUser').click(function() {
			if(confirm('Voulez-vous vraiment bannir cet utilisateur ?'))
				$(this).parent().submit();
		});

		$('.submitUnbanUser').click(function() {
			if(confirm('Voulez-vous vraiment gracier cet utilisateur ?'))
				$(this).parent().submit();
		});
	});

	</script>

@endsection
