<?php

namespace App\Http\Controllers;

use App\Requests\Equipment\EquipmentRequest;
use App\Repositories\EquipmentRepository;
use App\Repositories\EquipmentTypeRepository;

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
        $this->middleware('auth:admin'); //Requires admin permission
        //TODO access levels
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\Equipment\EquipmentRequest $request
     * @param  int  $id_equipment_type
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentRequest $request, $id_equipment_type)
    {
        if(!is_numeric($id_equipment_type) || $this->equipmentTypeRepository->exists($id_equipment_type)) abort(404);
        $request->merge(['id_equipment_type' => $id_equipment_type]);
        
        $equipment = $this->equipmentRepository->store($request->all());
        $links = $type->equipment()->paginate($this->amountPerPage)->render();
        return response()->json([
            'id' => $equipment->id_equipment,
            'serial_number' => $equipment->serial_number,
            'token' => csrf_token(),
            'links' => $links->toHtml()
        ]);
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
        $type = $equipment->type();
        if(!$type->contains($id_equipment_type)) abort(400);
        
        $type = $type->get();

        return view('admin.equipment.show', compact('equipment', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\Equipment\EquipmentRequest $request
     * @param  int  $id_equipment_type
     * @param  int  $id_type
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentRequest $request, $id_equipment_type, $id_equipment)
    {
        if(!is_numeric($id_equipment_type) || !is_numeric($id_equipment)) abort(404);
        
        $equipment = $this->equipmentRepository->getById($id_equipment);
        if(!$equipment->type()->contains($id_equipment_type)) abort(400);
    
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
        if(!$equipment->type()->contains($id_equipment_type)) abort(400);

        $serial = $equipment->serial_number;
        $this->equipmentRepository->destroy($id_equipment);
        return redirect('admin/site')->withOk("Le matériel " . $equipment . " a été supprimé.");
    }
}
