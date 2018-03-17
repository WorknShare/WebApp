@extends('layouts.backoffice')

@section('title')
Types de matériel
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Types de matériel @endslot
	  @slot('description')Liste des types @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Types de matériel</li>
@endsection

@section('content')
@component('components.ajax_managed_page', [
  'routeStore' => 'equipmenttype.store',
  'routeUpdate' => 'equipmenttype.update',
  'routeDestroy' => 'equipmenttype.destroy',
  'routeShow' => 'equipmenttype.show',
  'placeholder' => 'Nom',
  'fieldName' => 'name',
  'noResourceMessage' => 'Il n\'y a aucun type de matériel',
  'resources' => $types,
  'links' => $links,
  'canManage' => Auth::user()->role <= 2 && Auth::user()->role > 0
  ])
@endcomponent
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajaxresource.js') }}"></script>
<script type="text/javascript">
  var manager = new AjaxResourceManager(
    'Type de matériel créé !',
    'Type de matériel supprimé.',
    'Type de matériel modifié.',
    'Une erreur est survenue. Impossible de supprimer ce type de matériel.',
    'Voulez-vous vraiment supprimer ce type de matériel ?',
    'name',
    true
    );
</script>
@endsection