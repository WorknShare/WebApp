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
@if($advantagesCount <= 0)
<div class="alert alert-info alert-dismissible"><i class="fa fa-info-circle"></i><b class="overflow-break-word">Aucun avantage de forfait n'a été créé. Vous devez <a href="{{ route('planadvantage.index') }}">créer des avantages de forfait</a> avant de pouvoir créer un forfait.</b></div>
@endif

@if(count($plans))
<div class="box-body no-padding">
  <table class="table table-striped" style="table-layout: fixed;">
    <tr>
      <th style="width: 10px">#</th>
      <th>Nom</th>
    </tr>
    @foreach ($plans as $plan)
    <tr>
    	<td>{{ $plan->id_plan }}</td>
      <td class="ellipsis" title="{{ $plan->name }}"><b><a href="{{ route('plan.show', $plan->id_plan) }}">{{ $plan->name }}</a></b></td>
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
		@if($advantagesCount > 0)
		{{ link_to_route('plan.create', 'Ajouter un forfait', [], ['class' => 'btn btn-primary pull-right']) }}
		@endif
		{{ $links }}
	</div>
</div>
@endsection
