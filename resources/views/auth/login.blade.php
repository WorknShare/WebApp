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
    <a href="../../index2.html"><b>Admin</b>LTE</a>
</div>
<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ route('login') }}" method="post">
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
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-7">
              <div class="checkbox icheck">
                <label>
                    <input type="checkbox" id="remember" value="1" name="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
              </label>
          </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Se connecter</button>
      </div>
      <!-- /.col -->
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
<script>
  $(function () {
    $('#remember').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
  });
});
</script>
@endsection