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
			{!! Form::model($user, ['route' => ['myaccount.updatepwd'], 'method' => 'put']) !!}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('password', 'oldPwd', $errors, '', 'Ancien mot de passe', 'glyphicon-font', 'Ancien mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('password', 'password', $errors, '', 'Nouveau mot de passe', 'glyphicon-font', 'Nouveau mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
                {!! Form::controlWithIcon('password', 'confirmedPwd', $errors, '', 'Confirmer mot de passe', 'glyphicon-font', 'Confirmer mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
	          	</div>

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
		          <a class="btn btn-default pull-left" href='{{ route('myaccount.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection
