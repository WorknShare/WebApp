@extends('layouts.backoffice')

@section('title')
Modifier un site
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title'){{ $site->name }} @endslot
	  @slot('description')Modifier un site @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('site.index') }}"><i class="fa fa-map-marker"></i> Sites</a></li>
	<li><a href="{{ route('site.show', $site->id_site) }}">{{ $site->name }}</a></li>
	<li class="active">Modifier</li>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			{!! Form::model($site, ['route' => ['site.update', $site->id_site], 'method' => 'put']) !!}
	        	<div class="box-body">
		            {!! Form::controlWithIcon('text', 'name', $errors, $site->name, 'Nom', 'glyphicon-font', 'Nom', ["maxlength" => '255', "required" => "required"]) !!}
		            {!! Form::controlWithIcon('text', 'address', $errors, $site->address, 'Adresse', 'glyphicon-map-marker', 'Adresse', ["maxlength" => '255', "required" => "required"]) !!}
		            <div class="row">
				        <div class="col-xs-12 col-md-6">
				            {!! Form::iCheckbox('wifi', 'Wifi', $errors, $site->wifi) !!}
				        </div>
				        <div class="col-xs-12 col-md-6">
				            {!! Form::iCheckbox('drink', 'Boissons', $errors, $site->drink) !!}
				        </div>
				    </div>
	          	</div>
	          	<!-- /.box-body -->

		        <div class="box-footer">
		          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Modifier</button>
		          <a class="btn btn-default pull-left" href='{{ route('site.show', $site->id_site) }}'"> <i class="fa fa-chevron-left"></i> Retour</a>
		        </div>
	        </form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! iCheckScript() !!}
@endsection