<div class="box box-solid">
  <div class="box-body">
    @if(isset($canManage) ? $canManage : false)
    <div class="row">
      <div class="col-sm-12 col-md-8 col-lg-6">
        <form action="{{ isset($parentResourceId) ? route($routeStore, $parentResourceId) : route($routeStore) }}" method="POST" id="formCreateResource">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-xs-10">
              <div class="form-group has-feedback" id="descriptionGroup">
                <input class="form-control" placeholder="{{ $placeholder }}" id="description" maxlength="255" name="{{ $fieldName }}" type="text" value='' required>
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
              </div>
            </div>
            <div class="col-xs-2" style="padding:0">
              <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <span class="hidden-xs">Ajouter</span></button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @endif

    <div class="box-body no-padding {{ !count($resources) ? 'hidden' : '' }}" id="resources-row">
      <table class="table table-striped" id="resources-table">
        <tr>
          <th style="width: 10px">#</th>
          <th>Nom</th>
          @if(isset($canManage) ? $canManage : false)
          <th style="width:30px"></th>
          <th style="width:30px"></th>
          @endif
        </tr>
        @foreach ($resources as $resource)
        <tr class="resource-row">
        	<td>{{ $resource->id }}</td>
          <td class="break-word">
            {!! Form::model($resource, ['route' => isset($parentResourceId) ? [$routeUpdate, $parentResourceId, $resource->id] : [$routeUpdate, $resource->id], 'method' => 'put', 'class' => 'form-edit-resource']) !!}
              @if(isset($routeShow))
              <span class="resource-description"><b><a href="{{ isset($parentResourceId) ? route($routeShow, ['equipmenttype'=> $parentResourceId, 'equipment'=>$resource->id]) : route($routeShow, $resource->id) }}">{{ $resource->description }}</a></b></span>
              @else
              <span class="resource-description">{{ $resource->description }}</span>
              @endif
            {!! Form::close() !!}
          </td>
          @if(isset($canManage) ? $canManage : false)
          <td><a class="text-primary editResource point-cursor" value="Modifier"><i class="fa fa-pencil"></i></a></td>
          <td>
            {{ Form::open(['method' => 'DELETE', 'route' => isset($parentResourceId) ? [$routeDestroy, $parentResourceId, $resource->id] : [$routeDestroy, $resource->id]]) }}
              <a class="text-danger submitDeleteResource point-cursor" value="Supprimer" type="submit"><i class="fa fa-trash"></i></a>
            {{ Form::close() }}
          </td>
          @endif
        </tr>
    	@endforeach
      </table>
    </div>

    <div class="row {{ count($resources) ? 'hidden' : '' }}" id="no-resource-row">
    	<div class="col-xs-12">
    		<h4 class="text-muted">{{ $noResourceMessage }}.</h4>
    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-12" id="pagination-container">
    		{{ $links }}
    	</div>
    </div>
  </div>
</div>