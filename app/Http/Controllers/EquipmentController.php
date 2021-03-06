<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\EquipmentRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Equipment\EquipmentAffectRequest;
use App\Repositories\EquipmentRepository;
use App\Repositories\EquipmentTypeRepository;
use Carbon\Carbon;
use App\Jobs\DeletedItemMailJob;

class EquipmentController extends Controller
{

    private $equipmentRepository;
    private $equipmentTypeRepository;
    private $amountPerPage = 10;

    /**
     * Create a new PlanAdvantageController instance
     *
     * @param \App\Repositories\EquipmentTypeRepository $equipmentTypeRepository
     * @param \App\Repositories\EquipmentRepository $equipmentRepository
     * @return void
     */
    public function __construct(EquipmentRepository $equipmentRepository, EquipmentTypeRepository $equipmentTypeRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
        $this->middleware('auth:admin', ['except' => ['indexApp']]); //Requires admin permission
        $this->middleware('password', ['except' => ['indexApp']]);
        $this->middleware('access:2', ['except' => ['show', 'indexApp']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Equipment\EquipmentRequest $request
     * @param  int  $id_equipment_type
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentRequest $request, $id_equipment_type)
    {
        if(!is_numeric($id_equipment_type) || !$this->equipmentTypeRepository->exists($id_equipment_type)) abort(404);
        $request->merge(['id_equipment_type' => $id_equipment_type]);

        $equipment = $this->equipmentRepository->store($request->all());
        $type = $this->equipmentTypeRepository->getById($id_equipment_type);
        $links = $type->equipment()->paginate($this->amountPerPage)->render();
        return response()->json([
            'id' => $equipment->id_equipment,
            'description' => $equipment->serial_number,
            'token' => csrf_token(),
            'links' => $links->toHtml()
        ]);
    }

    public function indexApp(SearchRequest $request)
    {

      if(!empty($request->search))
      {
        $equipment = $this->equipmentRepository->getWhereWithRelations($request->search, $this->amountPerPage, $request->filter);
        return response()->json([
          "data" => [
            "items" => $equipment
          ]
        ]);
      }
      else{

        $equipment = $this->equipmentRepository->getPaginateApp($this->amountPerPage, $request->filter);
        return response()->json([
          "data" => [
            "items" => $equipment->items(),
            "paginator" => [
              "currentPage" => $equipment->currentPage(),
              "perPage" => $equipment->perPage(),
              "lastPage" => $equipment->lastPage()
            ]
          ]
        ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_equipment_type
     * @param  int  $id_type
     * @return \Illuminate\Http\Response
     */
    public function show($id_equipment_type, $id_equipment)
    {
        if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);

        $equipment = $this->equipmentRepository->getById($id_equipment);
        $type = $equipment->type()->first();

        if($type->id_equipment_type != $id_equipment_type) abort(400);

        $site = $equipment->site()->first();
        $siteId = is_null($site) ? 0 : $site->id_site;

        return view('admin.equipment.show', compact('equipment', 'type', 'site', 'siteId'));
    }

    public function calendar($id_equipment_type, $id_equipment)
    {
      if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);

      $equipment = $this->equipmentRepository->getById($id_equipment);
      $type = $equipment->type()->first();
      if($type->id_equipment_type != $id_equipment_type) abort(400);
      $calendar = $equipment->reserve()->join('clients', 'reserve_room.id_client', '=', 'clients.id_client')->select('reserve_room.*', 'clients.name')->get();
      return response()->json([
          'calendar' => $calendar
      ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Equipment\EquipmentRequest $request
     * @param  int  $id_equipment_type
     * @param  int  $id_type
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentRequest $request, $id_equipment_type, $id_equipment)
    {
        if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);

        $equipment = $this->equipmentRepository->getById($id_equipment);
        $type = $equipment->type()->first();
        if($type->id_equipment_type != $id_equipment_type) abort(400);

        $request->merge(['id_equipment_type' => $id_equipment_type]);

        $equipment->update($request->all());
        return response()->json([
            'text' => $request->serial_number
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_equipment_type
     * @param  int  $id_type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_equipment_type, $id_equipment)
    {
        if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);

        $equipment = $this->equipmentRepository->getById($id_equipment);
        $type = $equipment->type()->first();
        if($type->id_equipment_type != $id_equipment_type) abort(400);

        $reserves = $equipment->reserve()->where([['is_deleted', 0], ['date_start', '>', date('Y-m-d H:i:s')]])->get();

        foreach ($reserves as $key => $reserve) {
          $user = $reserve->user()->first();
          $emailJob = (new DeletedItemMailJob($user, $equipment , $reserve))->delay(Carbon::now()->addSeconds(12));
          dispatch($emailJob);
          $reserve->equipments()->detach($equipment->id_equipment);
          $reserve->save();
        }

        $this->equipmentRepository->destroy($id_equipment);

        $equipments = $type->equipment()->select(['serial_number AS description', 'id_equipment as id'])->where('is_deleted','=',0)->paginate($this->amountPerPage);
        $equipments->setPath(route('equipmenttype.show', $id_equipment_type));
        $links = $equipments->render();

        return response()->json([
            'url'        => route('equipmenttype.show', $id_equipment_type),
            'links'      => $links->toHtml(),
            'token'      => csrf_token(),
            'resources' => $equipments->items()
        ]);
    }

    /**
     * Affects the specified resource to a site.
     *
     * @param  \App\Http\Requests\Equipment\EquipmentAffectRequest $request
     * @param  int  $id_equipment_type
     * @param  int  $id_type
     * @return \Illuminate\Http\Response
     */
    public function affect(EquipmentAffectRequest $request, $id_equipment_type, $id_equipment)
    {
        if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);

        $equipment = $this->equipmentRepository->getById($id_equipment);
        $type = $equipment->type()->first();
        if($type->id_equipment_type != $id_equipment_type) abort(400);

        if($request->site == 0)
        {
            $equipment->site()->dissociate();
            $orders = $this->equipmentRepository->getById($id_equipment)->reserve()->get();
            foreach ($orders as $key => $order) {
              $model = \App\ReserveRoom::findOrFail($order->id_reserve_room);
              $model->is_deleted = true;
              $model->save();
            }
        }
        else
        {
            $site = \App\Site::where('is_deleted','=',0)->find($request->site);

            if(!is_null($site))
                $equipment->site()->associate($request->site);
            else
                abort(400);

            $orders = $this->equipmentRepository->getById($id_equipment)->reserve()->where('is_deleted', '=', 0)->get();
            foreach ($orders as $key => $order) {
              $model = \App\ReserveRoom::findOrFail($order->id_reserve_room);
              $model->is_deleted = true;
              $model->save();
            }
        }

        $equipment->save();

        return response()->json();
    }
}
