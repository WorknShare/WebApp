@extends('layouts.app_public')

@section('title')
Work'n Share - S'inscrire
@endsection

@section('css')
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/minimal/blue.css') }}">
<style type="text/css">
    body {
        background-color: #ffffff;
    }

    .checkbox label, .radio label {
        padding-left: 0px;
    }

    .ImageBackground--overlay::before {
        background-color: rgba(0,0,0,0.2);
    }

</style>
<link rel="stylesheet" href="{{ asset('css/wave.css') }}">
@endsection

@section('content-wrapper')
<section class="full-height">
    <div class="ImageBlock ImageBlock--switch u-FlexCenter u-xs-Block full-height">
        <div class="ImageBlock__image col-md-6 col-sm-4 hidden-sm hidden-xs">
            <div class="ImageBackground ImageBackground--overlay u-BoxShadow100 bg-primary bg-primary--gradient310" data-overlay="5" id="wave-container">
            </div>
        </div>
        <div class="container container--default">
            <div class="row u-FlexCenter u-xs-Block">
                <div class="col-md-5 text-white hidden-sm hidden-xs">
                    <a href="{{ route('welcome') }}"><img class="retina" src="{{ asset('img/banner64_2.png') }} " alt=""></a>
                    <h1 class="u-MarginTop60 u-MarginBottom15 shadow">Votre espace de coworking</h1>
                    <p class="u-MarginBottom50 text-white shadow">Boostez votre productivité.</p>
                </div>
                <div class="col-md-5 col-md-offset-2">
                    <h1 class="u-xs-FontSize40 u-Weight300 u-MarginTop0 u-xs-MarginTop0 u-MarginBottom15 u-MarginTop15 u-xs-MarginTop30 u-sm-MarginTop30">S'inscrire</h1>
                    <p class="u-LineHeight2 u-MarginBottom50">Saisissez vos informations pour compléter l'inscription</p>
                    <form action="{{ route('register') }}" method="post">
                        {{ csrf_field() }}
                        {!! Form::control('email', 'email', $errors, old('email'), 'Email', '', ["maxlength" => '255', "required" => "required"]) !!}
                        {!! Form::control('text', 'surname', $errors, old('surname'), 'Prénom', '', ["maxlength" => '25', "required" => "required"]) !!}
                        {!! Form::control('text', 'name', $errors, old('name'), 'Nom', '', ["maxlength" => '25', "required" => "required"]) !!}
                        {!! Form::control('password', 'password', $errors, '', 'Mot de passe', '', ["required" => "required"]) !!}
                        {!! Form::control('password', 'password_confirmation', $errors, '', 'Confirmation du mot de passe', '', ["required" => "required"]) !!}
                        {!! Form::iCheckbox('terms', 'J\'accepte les <a href="#">CGU</a>', $errors) !!}
                        <button type="submit" class="btn btn-primary btn-block btn-flat">S'inscrire</button>

                        <p class="u-MarginTop60 u-xs-MarginTop30">
                            Vous avez déjà un compte? <a href="{{ route('login') }}" class="btn-go btn-go--info">Connectez-vous</a>
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
<script src="{{ asset('landing/js/three.min.js') }}"></script>
<script src="{{ asset('landing/js/three.controls.orbit.js') }}"></script>
<script src="{{ asset('landing/js/wave.js') }}"></script>
@endsection