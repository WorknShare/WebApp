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
    @component('components.plan_comparative', [
          'plans' => $plans,
          'planAdvantages'=> $planAdvantages,
          'reserveCount' => $reserveCount,
          'orderMealCount' => $orderMealCount])
		@endcomponent
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@component('components.footer')
@endcomponent
@endsection 
