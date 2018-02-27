@extends('layouts.backoffice')

@section('title')
Créer un site
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Sites @endslot
	  @slot('description')Créer un site @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li class="active">Créer un site</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<form action="{{ route('site.store') }}" method="post">
				{{ csrf_field() }}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, old('name'), 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'address', $errors, old('address'), 'Adresse', 'glyphicon-map-marker', 'Adresse', ["maxlength" => '255', "required" => "required"]) !!}
		            <div class="row">
				        <div class="col-xs-12 col-md-6">
				            {!! Form::iCheckbox('wifi', 'Wifi', $errors, old('wifi')) !!}
				        </div>
				        <div class="col-xs-12 col-md-6">
				            {!! Form::iCheckbox('drink', 'Boissons', $errors, old('drink')) !!}
				        </div>
				    </div>
	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Créer</button>
		          <a class="btn btn-default pull-left" href='{{ route('site.index') }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection
