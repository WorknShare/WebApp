 @extends('layouts.app')

@section('body-class')
skin-blue sidebar-mini
@endsection

@section('title')
Administration
@endsection

@section('navigation')
@include('partials.backoffice.navbar')
@endsection

@section('content-wrapper')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('page_title')
      <ol class="breadcrumb">
        @yield('breadcrumb_nav')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-triangle"></i><b class="overflow-break-word">{!! session('error') !!}</b></div>
      @endif
      @if(session()->has('warning'))
      <div class="alert alert-warning alert-dismissible"><i class="fa fa-excalamation-circle"></i><b class="overflow-break-word">{!! session('warning') !!}</b></div>
      @endif
      @if(session()->has('info'))
      <div class="alert alert-info alert-dismissible"><i class="fa fa-info-circle"></i><b class="overflow-break-word">{!! session('info') !!}</b></div>
      @endif
      @if(session()->has('ok'))
      <div class="alert alert-success alert-dismissible"><i class="fa fa-check"></i><b class="overflow-break-word">{!! session('ok') !!}</b></div>
      @endif
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection