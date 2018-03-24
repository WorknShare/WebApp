@extends('layouts.frontoffice')

@section('title')
Work'n Share - Paiement accepté
@endsection

@section('css')
<style type="text/css">
  #check {
    background-image: -webkit-linear-gradient(140deg,#457aff,#30d4b9); /* For Chrome and Safari */
    background-image:    -moz-linear-gradient(140deg,#457aff,#30d4b9); /* For old Fx (3.6 to 15) */
    background-image:     -ms-linear-gradient(140deg,#457aff,#30d4b9); /* For pre-releases of IE 10*/
    background-image:      -o-linear-gradient(140deg,#457aff,#30d4b9); /* For old Opera (11.1 to 12.0) */
    background-image:         linear-gradient(140deg,#457aff,#30d4b9); /* Standard */
    color:transparent;
    -webkit-background-clip: text;
    background-clip: text;
    font-size: 180.8px;
  }
</style>
@endsection

@section('content')

  <div class="row text-center">

    <div class="col-xs-12">
      <i class="fa fa-check-circle" id="check"></i>
    </div>

    <div class="col-xs-12">

        <div>
          <h1 class="u-MarginBottom15 u-MarginTop15">Paiement accepté.</h1>
          <h3 class="text-muted u-MarginTop0">Merci !</h3>

          <p>Votre commande numéro {{ session('commandNumber') }} a bien été enregistrée.</p>
        </div>
    </div>

  </div>

  <div class="row u-MarginTop15 u-MarginBottom50">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
      <a href="{{ route('myaccount.index') }}" class="btn btn-primary btn-lg btn-block">Retourner sur mon profil</a>
    </div>
  </div>
@endsection