@extends('layouts.backoffice')

@section('title')
  Type de salles
@endsection

@section('page_title')
  @component('components.header')
    @slot('title')Type de salles @endslot
      @slot('description')Liste des type de salles @endslot
      @endcomponent
    @endsection

    @section('breadcrumb_nav')
      <li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
      <li class="active">Type de salles</li>
    @endsection



    @section('content')
      <div class="box box-solid">
        <div class="box-body">
          <div class="row">
            <div class="col-sm-12 col-md-8 col-lg-6">
              <form action="{{ route('typeOfRooms.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-xs-10">
                    <div class="form-group has-feedback" id="descriptionGroup">
                      <input class="form-control" placeholder="name" maxlength="255" name="name" type="text" required>
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

            @if(count($typeOfRooms))

              <div class="box-body no-padding table-container-responsive">
                <table class="table table-striped">
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nom</th>
                    @if ( Auth::user()->role <= 2 && Auth::user()->role > 0)
                      <th style="width:30px"></th>
                      <th style="width:30px"></th>
                    @endif
                  </tr>
                  @foreach ($typeOfRooms as $typeOfRoom)
                    <tr>
                      <td>{{ $typeOfRoom->id_room_type }}</td>
                      <td class="break-word">
                        {!! Form::model($typeOfRoom, ['route' => ['typeOfRooms.update', $typeOfRoom->id_room_type], 'method' => 'put', 'class' => 'form-edit-type']) !!}
                          <span class="type-name">{{ $typeOfRoom->name }}</span>
                        {!! Form::close() !!}
                      </td>
                      @if (Auth::user()->role <= 2 && Auth::user()->role > 0)
                        <td><a class="text-primary editType point-cursor" value="Modifier"><i class="fa fa-pencil"></i></a></td>
                        <td>
                          {!! Form::model($typeOfRoom, ['route' => ['typeOfRooms.destroy', $typeOfRoom->id_room_type], 'method' => 'DELETE', 'id' => 'deleteType'. $typeOfRoom->id_room_type]) !!}
                            <a class="text-danger point-cursor"  onclick="document.getElementById('deleteType{{$typeOfRoom->id_room_type}}').submit()"><i class="fa fa-trash"></i></a>
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
                  <h4 class="text-muted">Il n'y a aucun site.</h4>
                </div>
              </div>
            @endif
            <div class="row">
              <div class="col-xs-12" id="pagination-container">
                {{ $links }}
              </div>
            </div>

        </div>

      </div>
    @endsection


    @section('scripts')
    <script type="text/javascript" src="{{ asset('js/typeofroom.js') }}"></script>
    @endsection
