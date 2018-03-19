@extends('layouts.backoffice')


@section('title')
Salle
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')<span id="title-room"></span> @endslot
	  @slot('description')Gestion de la salle @endslot
	@endcomponent
@endsection

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li><a id="route-site"></a></li>
	<li class="active" id="name-room"></li>
@endsection


@section('content')
	<div style="padding : 2%" class="box box-solid">
		<div class="box-header">
			<a class="btn btn-default pull-left" href='{{ route('site.show', $room->id_site) }}'> <i class="fa fa-chevron-left"></i> Retour</a>
		</div>
		<div class="box-body">
			<div id="container"></div>
		</div>
	</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/moment/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/fullcalendar/dist/locale-all.js') }}"></script>
@include('admin.rooms.calendarRoom')

@endsection
