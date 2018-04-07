@extends('layouts.frontoffice')

@section('title')
Historique
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Historique @endslot
	  @slot('description')les réservations @endslot
	@endcomponent
@endsection

@section('content')
	<div class="content">

	</div>
	<div class="col-md-12 u-MarginBottom95">
	  <ul class="nav nav-tabs u-BoxShadow100" role="tablist">
	    <li role="presentation" class="active"><a href="#rooms" aria-controls="philosophy" role="tab" data-toggle="tab" aria-expanded="true">Salles</a></li>
	    <li role="presentation" class=""><a href="#meals" aria-controls="mission" role="tab" data-toggle="tab" aria-expanded="false">Repas</a></li>
	    <li role="presentation" class=""><a href="#devices" aria-controls="goal" role="tab" data-toggle="tab" aria-expanded="false">Equipement</a></li>
	  </ul>
	  <div class="tab-content u-BoxShadow100">
	    <div role="tabpanel" class="tab-pane fade active in" id="rooms">
	      <div class="u-LineHeight2">
					<div id="order_content">
						@include('order.order_history')
					</div>
				</div>
	    </div>
	    <div role="tabpanel" class="tab-pane fade" id="meals">
	      <div class="u-LineHeight2">
					<div id="meal_content">
						@include('order.meal_history')
					</div>
				</div>
	    </div>
	    <div role="tabpanel" class="tab-pane fade" id="devices">
	      <div class="u-LineHeight2">
	      </div>
	    </div>
	  </div>
	</div>

	<div class="box-footer">
		<a class="btn btn-default pull-left" href='{{ route('myaccount.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
	</div>

@endsection


@section('scripts')
	<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
  <script type="text/javascript">
		$('.DeleteOrder').click(function() {
			if(confirm('Voulez-vous annuler cette commande ?')){
				var id_table = $(this).parent().parent().parent().parent().attr('id');

				if(id_table === 'meals_table')
					var url = "{{ route('mealorder.destroy', ':id') }}";
				else if(id_table === 'orders_table')
					var url = "{{ route('order.destroy', ':id') }}";
				else return;

				url = url.replace(':id', $(this).parent().find('span').text());
				console.log(url);
				var parent = $(this).parent().parent();
				$.ajax({
					method : 'DELETE',
					url : url,
					dataType: 'json',
					data: { _token: '{{csrf_token()}}' },
				}).done(function (data) {
					console.log(data);
					$.alert('success', data);
					parent.find('.badge_is_deleted').html('{!! Html::badge_reserve() !!}');
					parent.find('.delete_button').html('');
				}).fail(function () {
					alert('resource could not be loaded.');
				});
			}

		});

		$(function(){
			$(document).on('click', '#link_meal .pagination a', function (e) {
					getData($(this).attr('href').split('page=')[1], 'meal');
					e.preventDefault();
			});

			$(document).on('click', '#link_order .pagination a', function (e) {
					console.log('test');
					getData($(this).attr('href').split('page=')[1], 'order');
					e.preventDefault();
			});
		});

    function getData(page, resource = null) {
			console.log(page, resource);
			if(page == Number.NaN || page <= 0 || resource == null) return false;
			console.log(page, resource);
      var url = '{{ route('order.history')}}?page=' + page+'&resource=' + resource;
        $.ajax({
            url : url,
            dataType: 'json',
        }).done(function (data) {
						if(resource === 'meal') $('#meal_content').html(data);
						else if(resource === 'order') $('#order_content').html(data);
        }).fail(function () {
            alert('Posts could not be loaded.');
        });
    }
  </script>
@endsection
