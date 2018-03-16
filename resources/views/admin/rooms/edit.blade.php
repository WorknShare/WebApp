@extends('layouts.backoffice')

@section('title')
  Modifier une salle
@endsection

@section('page_title')
  @component('components.header')
    @slot('title'){{ $room->name }} @endslot
    @slot('description')Modifier une salle @endslot
  @endcomponent
@endsection

@section('breadcrumb_nav')
  <li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
  <li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
  <li><a href="{{ route('site.show', $room->id_room) }}">{{ $room->name }}</a></li>
  <li class="active">Modifier</li>
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('content')
  <div class="row">
      <div class="col-xs-12">
        <div class="box box-solid">
          {!! Form::model($room, ['route' => ['room.update', $room->id_room], 'method' => 'put']) !!}
          <div class="box-body">
            <input style="margin-bottom : 2%" type="hidden" value="{{ $room->id_site }}" name="id_site">
            {!! Form::controlWithIcon('text', 'name', $errors, $room->name, 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}

              <label for="type">Type de salle</label>
              <select  id='type' style="margin-bottom : 2%" name="id_room_type" class="select2 form-control ">
                @foreach(App\RoomTypes::all() as $roomtType)
                  <option value="{{ $roomtType->id_room_type }}" {{$roomtType->id_room_type == $room->id_room_type ? 'selected' : ''}}>{{ $roomtType->name }}</option>
                @endforeach
              </select>

            {!! Form::controlWithIcon('number', 'place', $errors, $room->place, 'Nombre de personnes maximum', 'glyphicon-map-marker', 'place', ["min" => '1']) !!}
          </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
            <a class="btn btn-default pull-left" href='{{ route('site.show', $room->id_site) }}'> <i class="fa fa-chevron-left"></i> Retour</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

  @section('scripts')
    <script type="text/javascript" src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.select2').select2();
      });
    </script>
  @endsection
