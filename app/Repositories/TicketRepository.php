<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
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
        return $this->model->whereRaw('LOWER(description) LIKE ?', array($search))
            ->with('equipment')
            ->take($limit)->get();
    }

}