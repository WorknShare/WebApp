@extends('layouts.frontoffice')

@section('title')
Repas
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $site->name }} @endslot
	  @slot('description')Commande @endslot
	@endcomponent
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
  	<div class="box box-solid">
      <form action="{{ route('order.store') }}" method="post">
  			{{ csrf_field() }}
        	<div class="box-body">
            <div class="form-group">
              <label class="control-label">Les Repas</label>
              <select name="id_room_type" class="form-control">
                @foreach($meals as $meal)
                  <option value="{{ $meal->id_meal }}">{{ $meal->name }}</option>
                @endforeach
              </select>
            </div>
            <div class='input-group date' id='datepicker'>
              <input id="date" type='text' class="form-control" name="date"/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            <div class="col-xs-12 col-sm-6">
              {!! Form::timePicker('hour_opening', $errors, 'heure :') !!}
            </div>
          </div>

	        <div class="box-footer">
	          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Commander</button>
	          <a class="btn btn-default pull-left" href='{{ route('site.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
	        </div>
      </form>
  	</div>
  </div>
</div>
@endsection
