@extends('layouts.frontoffice')

@section('title')
Modifier
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Profil @endslot
	  @slot('description')Modifer le mot de passe @endslot
	@endcomponent
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			{!! Form::model($user, ['route' => ['myaccount.updatepwd'], 'method' => 'put']) !!}
	        	<div class="box-body">
		            {!! Form::control('password', 'oldPwd', $errors, '', 'Ancien mot de passe', 'Ancien mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
		            {!! Form::control('password', 'password', $errors, '', 'Nouveau mot de passe', 'Nouveau mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
                {!! Form::control('password', 'password_confirmation', $errors, '', 'Confirmer mot de passe', 'Confirmer mot de passe', ["maxlength" => '60', "required" => "required"]) !!}
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
