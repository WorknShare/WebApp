@extends('layouts.backoffice')


@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
@endsection

@section('content')
  <div style="visibility : hidden" id="route-calendar">{{ route('room.calendar', $room->id_room)}}</div>
  <div id="container"></div>
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
