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
    </section>
@endsection
