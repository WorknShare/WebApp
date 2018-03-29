@extends('layouts.frontoffice')

@section('title')
Repas
@endsection


@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
      <form action="{{ route('meal.store') }}" method="post">
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
            <div class="row">
              <div class="date col-xs-12 col-sm-6" id='datepicker'>
                <div class="form-group ">
                    <label>date :</label>
                    <div class="input-group">
                        <input type="text" class="form-control timepicker" name="date" id="date">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6">
                {!! Form::timePicker('hour', $errors, 'heure :') !!}
              </div>
            </div>
            </div>


	        <div class="box-footer">
	          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Commander</button>
	          <a class="btn btn-default pull-left" href='{{ route('meal.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
	        </div>
      </form>
  	</div>
  </div>
</div>
@endsection


@section('scripts')
  <script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js') }}"></script>

  <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script type="text/javascript">
    $(function(){
      $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: 'd',
      });
      //Timepicker
      $('#hour').timepicker({
        minuteStep: 1,
        showInputs: false,
        showSeconds: false,
        showMeridian: false,
        defaultTime: {!! empty(old('start')) ? '"8:00"' : '"'.old('start').'"' !!},
        language:'fr',
      });

    });
  </script>
@endsection
