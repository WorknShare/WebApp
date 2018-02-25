@extends('layouts.app')

@section('title')
Se connecter
@endsection

@section('body-class')
login-page
@endsection

@section('content-wrapper')
<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('welcome') }}l"><img src="{{ asset('img/logo128.png') }}"></a>
    <div>
    Work'n Share
    </div>
  </div>
<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">Connectez-vous pour commencer votre session</p>

    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        {!! Form::controlWithIcon('email', 'email', $errors, old('email'), 'Email', 'glyphicon-envelope', ["maxlength" => '255']) !!}
        {!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock') !!}
        <div class="row">
            <div class="col-xs-7">
              {!! Form::iCheckbox('remember', 'Se souvenir de moi', $errors) !!}
            </div>
            <div class="col-xs-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Se connecter</button>
            </div>
        </div>
    </form>

    <a href="#">J'ai oublié mon mot de passe</a><br>
    <a href="{{ route('register') }}" class="text-center">S'inscrire</a>

</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection