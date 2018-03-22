@extends('layouts.app_public')

@section('navigation')
@include('partials.frontoffice.navbar')
@endsection

@section('content-wrapper')
<section class="u-PaddingTop150 u-PaddingBottom100 u-xs-PaddingTop70 u-xs-PaddingBottom0">
    <div class="container">

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
</section>

@component('components.footer_front')
@endcomponent

@endsection 
