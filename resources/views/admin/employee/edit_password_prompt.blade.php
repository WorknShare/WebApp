@extends('layouts.app')

@section('title')
Modifier le mot de passe
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
    <p class="login-box-msg">Veuillez modifier votre mot de passe</p>

    <form action="{{ route('employee.update_password', $id) }}" method="post">
        {{ csrf_field() }}
        @if(Auth::user()->role != 1 || Auth::user()->id_employee == $id)
        {!! Form::controlWithIcon('password', 'oldPassword', $errors, '', 'Mot de passe actuel', 'glyphicon-lock', '', ["required" => "required"]) !!}
        @endif
        {!! Form::controlWithIcon('password', 'password', $errors, '', 'Mot de passe', 'glyphicon-lock', '', ["required" => "required"]) !!}
        {!! Form::controlWithIcon('password', 'password_confirmation', $errors, '', 'Confirmation du mot de passe', 'glyphicon-log-in', '', ["required" => "required"]) !!}
        <div class="row">
            <div class="col-xs-offset-7 col-xs-5">
                <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">Envoyer</button>
            </div>
        </div>
        <div class="row mt-xs-10">
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