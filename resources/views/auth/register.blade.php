@extends('layouts.app')

@section('title')
S'inscrire
@endsection

@section('body-class')
register-page
@endsection

@section('content-wrapper')
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
</div>

<div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" class="form-control" name="email" placeholder="Email" maxlength="255" value="{!! old('email') !!}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="name" placeholder="Nom" maxlength="25" value="{!! old('name') !!}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group has-feedback{{ $errors->has('surname') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="surname" placeholder="Prénom" maxlength="25" value="{!! old('surname') !!}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('surname'))
        <span class="help-block">
            <strong>{{ $errors->first('surname') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password" placeholder="Mot de passe">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmation du mot de passe">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
          <div class="form-group has-feedback checkbox icheck {{ $errors->has('terms') ? ' has-error' : '' }}">
            <label>
              <input type="checkbox" id="terms" name="terms" value="1"> J'accepte les <a href="#">conditions d'utilisation</a>
          </label>
          @if ($errors->has('terms'))
          <span class="help-block">
            <strong>{{ $errors->first('terms') }}</strong>
          </span>
        @endif
      </div>
  </div>
  <!-- /.col -->
  <div class="col-xs-4">
      <button type="submit" class="btn btn-primary btn-block btn-flat">S'inscrire</button>
  </div>
  <!-- /.col -->
</div>
</form>

<a href="{{ route('login') }}" class="text-center">J'ai déjà un compte</a>
</div>
<!-- /.form-box -->
</div>
<!-- /.register-box -->
@endsection

@section('scripts')
<script>
  $(function () {
    $('#terms').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
  });
});
</script>
@endsection