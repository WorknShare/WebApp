@extends('layouts.app')

@section('body-class')
skin-blue sidebar-mini layout-top-nav
@endsection

@section('navigation')
@include('partials.frontoffice.navbar')
@endsection

@section('content-wrapper')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

   <!-- Main content -->
   <section class="container">
   	  @yield('page_title')
   	  <ol class="breadcrumb">
        @yield('breadcrumb_nav')
      </ol>
      @yield('content')

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@component('components.footer')
@endcomponent
@endsection 
