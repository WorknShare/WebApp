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