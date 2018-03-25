@extends('layouts.frontoffice')

@section('title')
Work'n Share - Forfaits
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Profil @endslot
	  @slot('description')Choix du forfait @endslot
	@endcomponent
@endsection

@section('content')

  <div class="row">
    <div class="col-xs-12">
      <h4>Récapitulatif de la commande</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive no-padding">
        <table class="table comparative-table">
          <tbody>
            <tr>
              <th>Nom du forfait</th>
              <th>Durée</th>
              <th>Prix</th>
            </tr>
            <tr>
              <td>{{ $plan->name }}</td>
              <td>1 mois</td>
              <td><span class="price-tag">{{ $plan->price }}€</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <h4>Informations de facturation</h4>
    </div>
  </div>

  <div class="row">
      <form action="{{ route('plan.payment', $plan->id_plan) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group col-xs-12 col-sm-4 {{ $errors->has('name') ? 'has-error' : '' }}">
          <label for="name">Nom</label>
          <input class="form-control" placeholder="Nom" id="name" maxlength="25" required="required" name="name" type="text" value="{{ old('name') }}">

          @if($errors->has('name'))
            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
          @endif
        </div>
        <div class="form-group col-xs-12 col-sm-4 {{ $errors->has('surname') ? 'has-error' : '' }}">
          <label for="surname">Prénom</label>
          <input class="form-control" placeholder="Prénom" id="surname" maxlength="25" required="required" name="surname" type="text" value="{{ old('surname') }}">

          @if($errors->has('surname'))
            <span class="help-block"><strong>{{ $errors->first('surname') }}</strong></span>
          @endif
        </div>
        <div class="form-group col-xs-12 col-sm-4 {{ $errors->has('phone') ? 'has-error' : '' }}">
          <label>Téléphone</label>

          <input class="form-control" pattern="^(\d{2}\s?){5}$" type="text" name="phone" value="{{ old('phone') }}" placeholder="Téléphone">
          @if($errors->has('phone'))
          <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
          @endif
        </div>
        <div class="form-group col-xs-12 col-sm-6 {{ $errors->has('address') ? 'has-error' : '' }}">
          <label for="address">Adresse</label>
          <input class="form-control" placeholder="Adresse" id="address" maxlength="255" required="required" name="address" type="text" value="{{ old('address') }}">

          @if($errors->has('address'))
            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
          @endif
        </div>
        <div class="form-group col-xs-7 col-sm-4 {{ $errors->has('city') ? 'has-error' : '' }}">
          <label for="city">Ville</label>
          <input class="form-control" placeholder="Ville" id="city" maxlength="255" required="required" name="city" type="text" value="{{ old('city') }}">

          @if($errors->has('city'))
            <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
          @endif
        </div>
        <div class="form-group col-xs-5 col-sm-2 {{ $errors->has('postal') ? 'has-error' : '' }}">
          <label for="postal">Code postal</label>
          <input class="form-control" placeholder="Code postal" pattern="[0-9]{5}" id="postal" maxlength="5" required="required" name="postal" type="text" value="{{ old('postal') }}">

          @if($errors->has('postal'))
            <span class="help-block"><strong>{{ $errors->first('postal') }}</strong></span>
          @endif
        </div>

        <div class="col-xs-12 u-MarginBottom20">
          <img src="{{ asset('dist/img/credit/visa.png') }}" alt="Visa">
          <img src="{{ asset('dist/img/credit/mastercard.png') }}" alt="Mastercard">
          <img src="{{ asset('dist/img/credit/american-express.png') }}" alt="American Express">
          <img src="{{ asset('dist/img/credit/paypal2.png') }}" alt="Paypal">
        </div>
        <div class="form-group col-xs-12 col-sm-6 {{ $errors->has('credit_card_number') ? 'has-error' : '' }}">
          <label for="credit_card_number">Numéro de carte bancaire</label>
          <input class="form-control" placeholder="Numéro de carte bancaire" pattern="[0-9]{16}" id="credit_card_number" maxlength="16" required="required" name="credit_card_number" type="text" autocomplete="off">

          @if($errors->has('credit_card_number'))
            <span class="help-block"><strong>{{ $errors->first('credit_card_number') }}</strong></span>
          @endif
        </div>

        <div class="form-group col-xs-8 col-sm-4 {{ $errors->has('exp_month') || $errors->has('exp_year') ? 'has-error' : '' }}">
          <div class="row">
            <label class="col-xs-12">Date d'expriation</label>
          </div>
          <div class="row">
            <div class="col-xs-6">
              
              <select class="form-control" required name="exp_month" autocomplete="off">
                <option disabled selected value> -- Mois -- </option>
              <?php $currentYear = date('Y'); ?>
              @foreach(range(1,12) as $month)
                  <option value="{{ sprintf("%02d", $month) }}">
                      {{ sprintf("%02d", $month) }}
                  </option>
                @endforeach
              </select>
              @if($errors->has('exp_month'))
                <span class="help-block"><strong>{{ $errors->first('exp_month') }}</strong></span>
              @endif
            </div>
            <div class="col-xs-6">           
              <select class="form-control" required name="exp_year" autocomplete="off">
                <option disabled selected value> -- Année -- </option>
              <?php $currentYear = date('Y'); ?>
              @for($year = $currentYear + 25; $year >= $currentYear ; $year--)
                  <option value="{{ $year }}">
                      {{ $year }}
                  </option>
                @endfor
              </select>
              @if($errors->has('exp_year'))
                <span class="help-block"><strong>{{ $errors->first('exp_year') }}</strong></span>
              @endif
            </div>
          </div>
        </div>
        <div class="form-group col-xs-4 col-sm-2 {{ $errors->has('csc') ? 'has-error' : '' }}">
          <label for="csc">CSC</label>
          <input class="form-control" placeholder="CSC" pattern="[0-9]{3}" id="csc" maxlength="3" required="required" name="csc" type="text" autocomplete="off">

          @if($errors->has('csc'))
            <span class="help-block"><strong>{{ $errors->first('csc') }}</strong></span>
          @endif
        </div>

        <div class="col-xs-12">
          <button class="btn btn-primary btn-lg pull-right" href='{{ route('plan.payment', $plan->id_plan) }}' type="submit"><i class="Icon Icon-lock Icon--24px u-MarginRight10"></i> Procéder au paiement</a>
        </div>
      </form>
  </div>
@endsection
