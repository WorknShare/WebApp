@extends('layouts.backoffice')

@section('title')
{{ $site->name }}
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Sites @endslot
	  @slot('description'){{ $site->name }} @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li class="active">{{ $site->name }}</li>
@endsection

@section('content')
Show sites admin
@endsection
