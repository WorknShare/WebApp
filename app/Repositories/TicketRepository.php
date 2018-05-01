<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Ticket;

class TicketRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param \App\Ticket $model 
     * @return void
     */
  	public function __construct(Ticket $model)
  	{
    	$this->model = $model;
  	}

	/**
     * Resource relative behavior for saving a record.
     * 
     * @param Model $model
     * @param array $inputs
     * @return int id, the id of the saved resource
     */
	protected function save(Model $model, Array $inputs)
	{
		
        $model->status = $inputs["status"];
        $model->description = $inputs["description"];
        $model->id_equipment = $inputs['id_equipment'];
        $model->id_employee_src = Auth::user()->id_employee;

        $model->save();

		return $model->id_ticket;
	}

    /**
     * Get the recordings matching the given WHERE clause
     *
     * @param array $column
     * @param int $limit
     * @return array
     */
    public function getWhereWithRelations($value,$limit=100, $filter=null)
    {
        $search = '%'.strtolower($value).'%';

        $query = $this->withRelations();

        $this->checkRoleAndFilter($query, $filter);

        $query->whereRaw('LOWER(description) LIKE ?', array($search))
            ->orWhereHas('equipment.type', function($query) use ($search) {
                    $query->whereRaw('LOWER(name) LIKE ?', array($search));
                });

        $this->checkRoleAndFilter($query, $filter); //Called multiple times in order to cover the subqueries too
            
        $query->orWhereHas('equipment', function($query) use ($search) {
                    $query->whereRaw('LOWER(serial_number) LIKE ?', array($search));
                });

        $this->checkRoleAndFilter($query, $filter);

        return $query->orderBy('created_at','desc')->take($limit)->get();
    }

    private function checkRoleAndFilter($query, $filter)
    {
        if($filter != null)
            $query->where('status', '=', $filter);

        if(Auth::user()->role == 4) //If technician, show only assigned tickets
            $query->where('id_employee_assigned', '=', Auth::user()->id_employee);
    }

    /**
     * Get a paginate of the recordings.
     *
     * @param int $n the amount of recordings per page
     * @return array
     */
    public function getPaginate($n,$filter=null)
    {
      $query = $this->withRelations()
            ->orderBy('created_at','desc');

        if(Auth::user()->role == 4) //If technician, show only assigned tickets
            $query->where('id_employee_assigned', '=', Auth::user()->id_employee);

        if($filter != null)
            $query->where('status', '=', $filter);

        return $query->paginate($n);
    }

    private function withRelations()
    {
        return $this->model
            ->with([
                'equipment' => function($query) {
                    $query->select('id_equipment', 'serial_number', 'id_equipment_type');
                }, 
                'equipment.type' => function($query) {
                    $query->select('id_equipment_type', 'name');
                },
                'employeeSource' => function($query) {
                    $query->select('id_employee', 'name', 'surname');
                },
                'employeeAssigned' => function($query) {
                    $query->select('id_employee', 'name', 'surname');
                }
            ]);
    }

    /**
     * Get all the recordings with their relations
     *
     * @return array
     */
    public function allWithRelations()
    {
        return $this->withRelations()->get();
    }

}