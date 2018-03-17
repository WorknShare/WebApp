@extends('layouts.backoffice')

@section('title')
Types de matériel
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Types de matériel @endslot
	  @slot('description'){{ $type->name }} @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li><a href="{{ route('equipmenttype.index') }}">Types de matériel</a></li>
  <li class="active">{{ $type->name }}</li>
@endsection

@section('content')
@component('components.ajax_managed_page', [
  'routeStore' => 'equipmenttype.equipment.store',
  'routeUpdate' => 'equipmenttype.equipment.update',
  'routeDestroy' => 'equipmenttype.equipment.destroy',
  'routeShow' => 'equipmenttype.equipment.show',
  'placeholder' => 'Numéro de série',
  'fieldName' => 'serial_number',
  'noResourceMessage' => 'Il n\'y a aucun matériel',
  'resources' => $equipment,
  'parentResourceId' => $type->id_equipment_type,
  'links' => $links,
  'canManage' => Auth::user()->role <= 2 && Auth::user()->role > 0
  ])
@endcomponent

<div class="row">
  <div class="col-xs-12">
    <a class="btn btn-default pull-left" href='{{ route('equipmenttype.index') }}'> <i class="fa fa-chevron-left"></i> Retour</a>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajaxresource.js') }}"></script>
<script type="text/javascript">
  var manager = new AjaxResourceManager(
    'Matériel créé !',
    'Matériel supprimé.',
    'Matériel modifié.',
    'Une erreur est survenue. Impossible de supprimer ce matériel.',
    'Voulez-vous vraiment supprimer ce matériel ?',
    'serial_number',
    true
    );
</script>
@endsection