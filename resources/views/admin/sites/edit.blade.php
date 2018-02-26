@extends('layouts.backoffice')

@section('title')
Modifier un site
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $site->name }} @endslot
	  @slot('description')Modifier un site @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li><a href="{{ route('site.show', $site->id_site) }}">{{ $site->name }}</a></li>
	<li class="active">Modifier</li>
@endsection

@section('content')
Edit site admin
@endsection
