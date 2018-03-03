@extends('layouts.backoffice')

@section('title')
Forfaits
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Forfaits @endslot
	  @slot('description')Liste des forfaits @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Forfaits</li>
@endsection

@section('content')


@if(count($plans))
<div class="box-body no-padding">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>Nom</th>
    </tr>
    @foreach ($plans as $plan)
    <tr>
    	<td>{{ $plan->id_plan }}</td>
      <td><b><a href="{{ route('plan.show', $plan->id_plan) }}">{{ $plan->name }}</a></b></td>
    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucun forfait.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
		{{ link_to_route('plan.create', 'Ajouter un forfait', [], ['class' => 'btn btn-primary pull-right']) }}
		{{ $links }}
	</div>
</div>

@endsection
