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
    <a href="{{ route('welcome') }}"><img src="{{ asset('img/logo128.png') }}"></a>
    <div>
    Work'n Share
    </div>
  </div>
<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">Se connecter au panel d'administration</p>

    <form action="{{ route('admin.login') }}" method="post">
        {{ csrf_field() }}
        {!! Form::controlWithIcon('email', 'email', $errors, old('email'), 'Email', 'glyphicon-envelope', '', ["maxlength" => '255', "required" => "required"]) !!}
        {!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock', '', ["required" => "required"]) !!}
        <div class="row">
            <div class="col-xs-7">
              {!! Form::iCheckbox('remember', 'Se souvenir de moi', $errors) !!}
            </div>
            <div class="col-xs-5">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Se connecter</button>
            </div>
            <div class="col-md-12 text-muted text-center p-t-10">
            En cas de mot de passe oublié, contactez un administrateur.
            </div>
        </div>
    </form>

</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection