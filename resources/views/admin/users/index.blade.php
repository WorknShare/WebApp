@extends('layouts.backoffice')

@section('title')
Sites
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Utilisateurs @endslot
	  @slot('description')Liste des utilisateurs @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">users</li>
@endsection

@section('content')


@endsection
