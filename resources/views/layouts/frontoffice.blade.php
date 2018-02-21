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
   	@if(!empty($title))
      @component('components.header')
          @slot('title')
              {{ $title }}
          @endslot
          @slot('description')
              {{ $description }}
          @endslot
      @endcomponent
      @endif
   	  <ol class="breadcrumb">
        @yield('breadcrumb_nav')
      </ol>
      @yield('content')

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="container">
      <strong>Copyright &copy; 2018 <a href="https://worknshare.fr">Work'n Share</a>.</strong> Tous droits réservés.
    </div>
    <!-- /.container -->
  </footer>
 @endsection 
