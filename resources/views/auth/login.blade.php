@extends('layouts.app_public')

@section('title')
Work'n Share - Se connecter
@endsection

@section('css')
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/minimal/blue.css') }}">
<style type="text/css">
    .checkbox label, .radio label {
        padding-left: 0px;
    }

    .ImageBackground--overlay::before {
        background-color: rgba(0,0,0,0.2);
    }

</style>
@endsection

@section('content-wrapper')
<section class="">
    <div class="ImageBlock ImageBlock--switch js-FullHeight u-FlexCenter u-xs-Block">
        <div class="ImageBlock__image col-md-6 col-sm-4 hidden-sm hidden-xs">
            <div class="ImageBackground ImageBackground--overlay u-BoxShadow100 bg-primary bg-primary--gradient310" data-overlay="5">
            </div>
        </div>
        <div class="container container--default">
            <div class="row u-FlexCenter u-xs-Block">
                <div class="col-md-5 text-white hidden-sm hidden-xs">
                    <a href="{{ route('welcome') }}"><img class="retina" src="{{ asset('img/banner64_2.png') }} " alt=""></a>
                    <h1 class="u-MarginTop60 u-MarginBottom15">Votre espace de coworking</h1>
                    <p class="u-MarginBottom50 text-white">Boostez votre productivité.</p>
                </div>
                <div class="col-md-5 col-md-offset-2">
                    <h1 class="u-xs-FontSize40 u-Weight300 u-MarginTop0 u-xs-MarginTop0 u-MarginBottom15 u-xs-MarginTop30">Se connecter</h1>
                    <p class="u-LineHeight2 u-MarginBottom50">Saisissez vos identifiants de connexion</p>
                    <form action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        {!! Form::control('email', 'email', $errors, old('email'), 'Email', '', ["maxlength" => '255', "required" => "required"]) !!}
                        {!! Form::control('password', 'password', $errors, '', 'Mot de passe', '', ["required" => "required"]) !!}
                        {!! Form::iCheckbox('remember', 'Se souvenir de moi', $errors) !!}
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Se connecter</button>

                        <p class="u-MarginTop60 u-xs-MarginTop30">
                            Vous n'avez pas de compte? <a href="{{ route('register') }}" class="btn-go btn-go--info">Inscrivez-vous</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
{!! iCheckScript() !!}
@endsection