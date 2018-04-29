@extends('layouts.frontoffice')

@section('title')
Repas
@endsection


@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css')}}">
  <link rel="stylesheet" href="{{ asset('css/custom.css')}}">

@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $site->name }} @endslot
	  @slot('description')Commande @endslot
	@endcomponent
@endsection

@section('content')
  @if(count($meals))
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-solid">
          <form action="{{ route('mealorder.store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$user->id_client}}" name="id_client">
            <input type="hidden" value="{{$site->id_site }}" name="id_site">
            <div class="box-body">
              <div class="form-group row">
                <div class="col-xs-12">
                  <label>Choix du menu</label><br>
                </div>
                @foreach($meals as $meal)
                  <div class="col-xs-6 col-sm-3 col-md-2" onclick="displayMore({{$meal->id_meal}})" title="{{ $meal->name }}">
                    {!! Form::radiobox('id_meal', $meal->name, $errors, $meal->id_meal, 'onclick="displayMore('.$meal->id_meal.')"') !!}
                  </div>
                @endforeach
                @if($errors->first('id_meal') != null)
                  <span class="help-block" style="color : #D33724"><strong>Il faut obligatoirement choisir un repas</strong></span>
                @endif
              </div>
              <div id="more" class="row" style="display : none; margin-bottom : 30px">
                <div class="col-xs-12 col-md-6">
                  <div class="row">
                    <label>Détails</label>
                  </div>
                  <div class="row">
                    <b style="color : #3C8DBC">Nom : </b><span id="more_name"></span>
                  </div>
                  <div class="row">
                    <b style="color : #3C8DBC">Prix : </b><span id="more_price"></span>€
                  </div>

                </div>
                <div class="col-xs-12 col-md-6">
                  <div class="row">
                    <label>Contenu</label>
                  </div>
                  <div class="row" id="more_content" style="white-space : pre-line">
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="date col-xs-12 col-sm-6" id='datepicker'>
                  <div class="form-group ">
                    <label>Date :</label>
                    <div class="input-group">
                      <input type="text" class="form-control timepicker" name="date" id="date">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  {!! Form::timePicker('hour', $errors, 'Heure :') !!}
                </div>
                @if($errors->first('date') != null)
                  <span class="help-block" style="color : #D33724"><strong> La date doit être postérieure au {{date('j/m/Y à  H:i !')}}</strong></span>
                @endif

              </div>
            </div>


            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Commander</button>
              <a class="btn btn-default pull-left" href='{{ route('mealorder.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  @else
    <div class="row">
    	<div class="col-xs-12">
    		<h4 class="text-muted">il n'y a pas de repas</h4>
    	</div>
    </div>
  @endif
@endsection


@section('scripts')
  <script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
  <script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

  <script type="text/javascript">
    $(function(){

      $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: 'd',
        language:'fr',
      });
      //Timepicker
      $('#hour').timepicker({
        minuteStep: 1,
        showInputs: false,
        showSeconds: false,
        showMeridian: false,
        defaultTime: {!! empty(old('start')) ? '"8:00"' : '"'.old('start').'"' !!},
      });

    });
  </script>

  {!! iCheckScript() !!}

  <script type="text/javascript">
    $('input').on('ifChecked', function(event){
      console.log(event.target.value);
      var url = '{{ route('mealorder.getmeal',':id' )}}';
      url = url.replace(':id', event.target.value);
      console.log(url);
      $.ajax({
        type : 'GET',
        url : url,
        dataType: "json"
      })
      .done(function(data) {
        console.log(data);
        $('#more').css('display', 'block');
        $('#more_name').text(data.name);
        $('#more_price').text(data.price);
        $('#more_content').html(data.content);
      })
      .fail(function(data) {
        console.log('error');
      });
    });
  </script>
@endsection
