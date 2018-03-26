@extends('layouts.frontoffice')

@section('title')
Work'n Share - Historique des paiements
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Profil @endslot
	  @slot('description')Historique des paiements @endslot
	@endcomponent
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('landing/css/responsive_buttons.css') }}">
@endsection

@section('content')

<div class="row">
  <div class="col-xs-12">
    <div class="table-responsive no-padding">
      <table class="table">
        <tbody>
          <tr>
            <th>Numéro de commande</th>
            <th>Forfait</th>
            <th>Date du paiement</th>
            <th>Date d'expiration</th>
            <th>Prix</th>
          </tr>
          @foreach($payments as $payment)
          <?php 
            $formatCreated = new DateTime($payment->created_at);
            $formatLimit = new DateTime($payment->limit_date);
          ?>
          <tr>
            <td class="overflow-break-word">{{ $payment->command_number }}</td>
            <td class="overflow-break-word">{{ $payment->plan->name }}</td>
            <td class="overflow-break-word">{{ $formatCreated->format('d/m/Y') }}</td>
            <td class="overflow-break-word">{{ $formatLimit->format('d/m/Y') }}</td>
            <td class="overflow-break-word">{{ $payment->plan->price }}€</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    {{ $links }}
  </div>
  <div class="col-xs-12 u-MarginBottom15">
    <a class="btn btn-default btn-responsive pull-left" href='{{ route('myaccount.index') }}' type="button"><i class="fa fa-chevron-left u-MarginRight10"></i> Retour</a>
  </div>
</div>
@endsection
