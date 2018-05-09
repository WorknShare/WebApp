@extends('layouts.backoffice')

@section('title')
  Type de salles
@endsection

@section('page_title')
  @component('components.header')
    @slot('title')Type de salles @endslot
    @slot('description')Liste des type de salles @endslot
  @endcomponent
@endsection

@section('breadcrumb_nav')
  <li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
  <li class="active">Type de salles</li>
@endsection

@section('content')
@component('components.ajax_managed_page', [
  'routeStore' => 'typeOfRooms.store',
  'routeUpdate' => 'typeOfRooms.update',
  'routeDestroy' => 'typeOfRooms.destroy',
  'placeholder' => 'Nom',
  'fieldName' => 'name',
  'noResourceMessage' => 'Il n\'y a aucun type de salle',
  'resources' => $typeOfRooms,
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
    'type de salle créé !',
    'type de salle supprimé.',
    'type de salle modifié.',
    'Une erreur est survenue. Impossible de supprimer ce type de salle.',
    'Voulez-vous vraiment supprimer ce type de salles ?\nToutes les salles rattachées à ce type seront supprimées !',
    'name'
    );
</script>
@endsection
