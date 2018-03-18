@extends('layouts.backoffice')

@section('title')
Modifier un utilisateur
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $user ->name }} @endslot
	  @slot('description')Modifier un utilisateur @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> Clients </a></li>
	<li class="active">Modifier {{ $user->name }}</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-solid">
        {!! Form::model($user, ['route' => ['user.update', $user->id_client], 'method' => 'put']) !!}
        <div class="box-body">
          {!! Form::controlWithIcon('text', 'name', $errors, $user->name, 'Nom', 'glyphicon-user', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
          {!! Form::controlWithIcon('text', 'surname', $errors, $user->surname, 'Prénom', 'glyphicon-user', 'Prénom', ["maxlength" => '255', "required" => "required"]) !!}
          {!! Form::controlWithIcon('email', 'email', $errors, $user->email, 'Email', 'fa fa-envelope', 'Email', ["maxlength" => '255', "required" => "required"]) !!}
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
          <a class="btn btn-default pull-left" href='{{ route('user.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection
