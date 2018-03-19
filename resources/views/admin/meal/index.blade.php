
@extends('layouts.backoffice')

@section('title')
Repas
@endsection
@section('page_title')
	@component('components.header')
	  @slot('title')Repas @endslot
	  @slot('description')Liste des repas @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Repas</li>
@endsection

@section('content')
@if(count($meals))
<div class="box-body no-padding table-container-responsive">
  <table class="table table-striped">
    <tr>
      <th style="width: 10px">#</th>
      <th>Nom</th>
      <th style="width:100px">Prix</th>
			<th style="width:30px"></th>
			<th style="width:30px"></th>
    </tr>
    @foreach ($meals as $meal )
    <tr>
    	 <td>{{ $meal->id_meal }}</td>
       <td><b><a href="{{ route('meal.show', $meal->id_meal) }}">{{$meal->name }}</a></b></td>
		   <td>{{ $meal->price }}€</td>
			 <td><a class="point-cursor" href="{{ route('meal.edit', $meal->id_meal) }}"><i class="fa fa-pencil"></td>
			 <td>
        {{ Form::open(['method' => 'DELETE', 'route' => ['meal.destroy', $meal->id_meal]]) }}
        <a class="text-danger submitDeleteMeal point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
        {{ Form::close() }}
     </td>
    </tr>
	@endforeach
  </table>
</div>
@else
<div class="row">
	<div class="col-xs-12">
		<h4 class="text-muted">Il n'y a aucun repas.</h4>
	</div>
</div>
@endif

<div class="row bottom-controls">
	<div class="col-xs-12">
    @if(Auth::user()->role <= 2 && Auth::user()->role > 0)
		{{ link_to_route('meal.create', 'Ajouter un repas', [], ['class' => 'btn btn-primary pull-right']) }}
    @endif
		{{ $links }}
	</div>
</div>

@endsection



@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('.submitDeleteMeal').click(function() {
                if(confirm('Voulez-vous vraiment supprimer ce repas ?'))
                $(this).parent().submit();
            });
        });
    </script>
@endsection
