@extends('layouts.backoffice')

@section('title')
Avantages de forfaits
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Avantages de forfaits @endslot
	  @slot('description')Liste des avantages @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Avantages de forfaits</li>
@endsection

@section('content')
<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-6">
        <form action="{{ route('planadvantage.store') }}" method="POST" id="formCreateAdvantage">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-xs-10">
              <div class="form-group has-feedback" id="descriptionGroup">
                <input class="form-control" placeholder="Description" id="description" maxlength="255" name="description" type="text" value='' required>
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
              </div>
            </div>
            <div class="col-xs-2" style="padding:0">
              <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <span class="hidden-xs">Ajouter</span></button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="box-body no-padding {{ !count($advantages) ? 'hidden' : '' }}" id="advantages-row">
      <table class="table table-striped" id="advantages-table">
        <tr>
          <th style="width: 10px">#</th>
          <th>Description</th>
          <th style="width:30px"></th>
          <th style="width:30px"></th>
        </tr>
        @foreach ($advantages as $advantage)
        <tr class="advantage-row">
        	<td>{{ $advantage->id_plan_advantage }}</td>
          <td class="break-word">
            {!! Form::model($advantage, ['route' => ['planadvantage.update', $advantage->id_plan_advantage], 'method' => 'put', 'class' => 'form-edit-advantage']) !!}
              <span class="advantage-description">{{ $advantage->description }}</span>
            {!! Form::close() !!}
          </td>
          <td><a class="text-primary editAdvantage point-cursor" value="Modifier"><i class="fa fa-pencil"></i></a></td>
          <td>
            {{ Form::open(['method' => 'DELETE', 'route' => ['planadvantage.destroy', $advantage->id_plan_advantage]]) }}
              <a class="text-danger submitDeleteAdvantage point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
            {{ Form::close() }}
          </td>
        </tr>
    	@endforeach
      </table>
    </div>

    <div class="row {{ count($advantages) ? 'hidden' : '' }}" id="no-advantage-row">
    	<div class="col-xs-12">
    		<h4 class="text-muted">Il n'y a aucun avantage.</h4>
    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-12" id="pagination-container">
    		{{ $links }}
    	</div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/planadvantages.js') }}"></script>
@endsection