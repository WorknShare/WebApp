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
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection