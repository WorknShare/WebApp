@extends('layouts.backoffice')

@section('title')
Avantages de forfaits
@endsection

@section('page_title')
	@component('components.header')
	  @slot('title')Avantages de forfaits @endslot
	  @slot('description')Liste des avantages @endslot
	@endcomponent
@endsection

@section('breadcrumb_nav')
	<li><a href="{{ route('admin.home') }}"><i class="fa fa-home"></i> Tableau de bord</a></li>
	<li class="active">Avantages de forfaits</li>
@endsection

@section('content')
@component('components.ajax_managed_page', [
  'routeStore' => 'planadvantage.store',
  'routeUpdate' => 'planadvantage.update',
  'routeDestroy' => 'planadvantage.destroy',
  'placeholder' => 'Description',
  'fieldName' => 'description',
  'noResourceMessage' => 'Il n\'y a aucun avantage de forfait',
  'resources' => $advantages,
  'links' => $links
  ])
@endcomponent
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/alertbuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajaxresource.js') }}"></script>
<script type="text/javascript">
  var manager = new AjaxResourceManager(
    'Avantage créé !',
    'Avantage supprimé.',
    'Avantage modifié.',
    'Une erreur est survenue. Impossible de supprimer cet avantage de forfait.',
    'Voulez-vous vraiment supprimer cet avantage de forfait ?',
    'description'
    );
</script>
@endsection