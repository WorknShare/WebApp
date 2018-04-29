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

@section('css')
	<link rel="stylesheet" href="{{ asset('css/comparative.css') }}">
@endsection

@section('content')
	<section>
        <div class="container">
            <div class="row media">
                @component('components.plan_comparative', [
                  'plans' => $plans,
                  'planAdvantages'=> $planAdvantages,
                  'reserveCount' => $reserveCount,
                  'orderMealCount' => $orderMealCount,
                  'showButtons' => true]),
                @endcomponent
            </div>
        </div>

        <div class="row">
          <div class="col-xs-12 u-MarginBottom15">
            <a class="btn btn-default btn-responsive pull-left" href='{{ route('myaccount.index') }}' type="button"><i class="fa fa-chevron-left u-MarginRight10"></i> Retour</a>
          </div>
        </div>
    </section>
@endsection
