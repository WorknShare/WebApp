@extends('layouts.frontoffice')

@section('title')
Modifier
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $user->name }} @endslot
	  @slot('description')Modifer vos informations personnelles @endslot
	@endcomponent
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			{!! Form::model($user, ['route' => ['myaccount.update', $user->id_client], 'method' => 'put']) !!}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, $user->name, 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '25', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'surname', $errors, $user->surname, 'Pseudo', 'glyphicon-font', 'Pseudo', ["maxlength" => '25', "required" => "required"]) !!}
                {!! Form::controlWithIcon('email', 'email', $errors, $user->email, 'Email', 'glyphicon-font', 'Email', ["maxlength" => '255', "required" => "required"]) !!}
	          	</div>

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
		          <a class="btn btn-default pull-left" href='{{ route('myaccount.index') }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection
