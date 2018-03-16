@extends('layouts.app')

@section('title')
Forfaits
@endsection

@section('body-class')
skin-blue sidebar-mini layout-top-nav
@endsection

@section('content-wrapper')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

   <!-- Main content -->
   <section class="container">
      	@component('components.plan_comparative', ['plans' => $plans, 'planAdvantages'=> $planAdvantages])
		@endcomponent
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
