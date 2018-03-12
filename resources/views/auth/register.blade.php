@extends('layouts.app')

@section('title')
S'inscrire
@endsection

@section('body-class')
register-page
@endsection

@section('content-wrapper')
<div class="register-box">
  <div class="login-logo">
    <a href="{{ route('welcome') }}"><img src="{{ asset('img/logo128.png') }}"></a>
    <div>
    Work'n Share
    </div>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">S'inscrire</p>

    <form action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
        {!! Form::controlWithIcon('email', 'email', $errors, old('email'), 'Email', 'glyphicon-envelope', '', ["maxlength" => '255', "required" => "required"]) !!}
        {!! Form::controlWithIcon('text', 'surname', $errors, old('surname'), 'Prénom', 'glyphicon-user', '', ["maxlength" => '25', "required" => "required"]) !!}
        {!! Form::controlWithIcon('text', 'name', $errors, old('name'), 'Nom', 'glyphicon-user', '', ["maxlength" => '25', "required" => "required"]) !!}
        {!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock', '', ["required" => "required"]) !!}
        {!! Form::controlWithIcon('password', 'password_confirmation', $errors, '', 'Confirmation du mot de passe', 'glyphicon-log-in', '', ["required" => "required"]) !!}
        <div class="row">
           <div class="col-xs-8">
            {!! Form::iCheckbox('terms', 'J\'accepte les <a href="#">CGU</a>', $errors) !!}
          </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">S'inscrire</button>
          </div>
        </div>
    </form>

    <a href="{{ route('login') }}" class="text-center">J'ai déjà un compte</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection