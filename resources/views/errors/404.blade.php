@extends('layouts.frontoffice', ['code' => 404])

@section('title')
Work'n Share - Erreur
@endsection

@section('content')
<div class="row">
	<div class="col-md-6 col-sm-6 text-right u-MarginTop100 u-xs-MarginTop0">
        <img class="img-fit-responsive " src="{{ asset('landing/imgs/404-icon.png') }}" alt=""/>
    </div>
    <div class="col-md-6 col-sm-6 u-MarginTop100 u-xs-MarginTop30 u-xs-MarginBottom30">
        <div class="u-MarginTop100 u-xs-MarginTop0 u-PaddingLeft50 u-xs-PaddingLeft0">
        	<h1 class="u-weight300" style="font-size:75px;">404</h1>
            <h1 class="u-weight300">Page itrouvable</h1>
        </div>
    </div>
</div>
@endsection
