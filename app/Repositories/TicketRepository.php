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
    public function getWhereWithRelations($value,$limit=100)
    {
        $search = '%'.strtolower($value).'%';

        $query = $this->model
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

        if(Auth::user()->role == 4) //If technician, show only assigned tickets
            $query->where('id_employee_assigned', '=', Auth::user()->id_employee);

        $query->whereRaw('LOWER(description) LIKE ?', array($search))
            ->orWhereHas('equipment.type', function($query) use ($search) {
                    $query->whereRaw('LOWER(name) LIKE ?', array($search));
                });

        if(Auth::user()->role == 4) //Second time to cover subqueries too
            $query->where('id_employee_assigned', '=', Auth::user()->id_employee);
            
        $query->orWhereHas('equipment', function($query) use ($search) {
                    $query->whereRaw('LOWER(serial_number) LIKE ?', array($search));
                })
            ->orderBy('created_at','desc');


        return $query->take($limit)->get();
    }

    /**
   * Get a paginate of the recordings.
   *
   * @param int $n the amount of recordings per page
   * @return array
   */
  public function getPaginate($n)
  {
    $query = $this->model->with([
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
        ])
        ->orderBy('created_at','desc');

    if(Auth::user()->role == 4) //If technician, show only assigned tickets
        $query->where('id_employee_assigned', '=', Auth::user()->id_employee);

    return $query->paginate($n);
  }

}