<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\EquipmentTypeRequest;
use App\Repositories\EquipmentTypeRepository;

class EquipmentTypeController extends Controller
{

    private $equipmentTypeRepository;
    private $amountPerPage = 10;

    /**
     * Create a new PlanAdvantageController instance
     * 
     * @param \App\Repositories\EquipmentTypeRepository $equipmentTypeRepository
     * @return void
     */
    public function __construct(EquipmentTypeRepository $equipmentTypeRepository)
    {
        $this->equipmentTypeRepository = $equipmentTypeRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        $this->middleware('password');
        //TODO access levels
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = $this->equipmentTypeRepository->getPaginateSelect($this->amountPerPage,['name AS description', 'id_equipment_type as id']);

        if ($types->isEmpty() && $types->currentPage() != 1)
        {
            return abort(404);
        }

        $links = $types->render();
        return view('admin.equipment.type_index', compact('types', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Equipment\EquipmentTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentTypeRequest $request)
    {
        $type = $this->equipmentTypeRepository->store($request->all());
        $links = $this->equipmentTypeRepository->getPaginate($this->amountPerPage)->render();
        return response()->json([
            'id' => $type->id_equipment_type,
            'description' => $type->name,
            'token' => csrf_token(),
            'links' => $links->toHtml()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) abort(404);
        $type = $this->equipmentTypeRepository->getById($id);
        $equipment = $type->equipment()->select(['serial_number AS description', 'id_equipment as id'])->paginate($this->amountPerPage);
        $links = $equipment->render();
        return view('admin.equipment.type_show', compact('type', 'equipment', 'links'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Equipment\EquipmentTypeRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentTypeRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);
        $this->equipmentTypeRepository->update($id, $request->all());
        return response()->json([
            'text' => $request->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id)) abort(404);
        $this->equipmentTypeRepository->destroy($id);

        $types = $this->equipmentTypeRepository->getPaginateSelect($this->amountPerPage,['name AS description', 'id_equipment_type as id']);
        $types->setPath(route('equipmenttype.index'));
        $links = $types->render();

        return response()->json([
            'url'        => route('equipmenttype.index'),
            'links'      => $links->toHtml(),
            'token'      => csrf_token(),
            'resources' => $types->items()
        ]);
    }
}
