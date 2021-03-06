<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Plan;

class PlanRepository extends ResourceRepository
{

    protected $softDeleted = true;

	/**
     * Create a new repository instance.
     *
     * @param App\Plan $model 
     * @return void
     */
  	public function __construct(Plan $model)
  	{
    	$this->model = $model;
  	}

    /**
     * Update a record
     *
     * @param int $id, the id of the record to update
     * @param array $inputs
     * @return void
     */
    public function update($id, Array $inputs)
    {
        
        $plan = $this->getById($id);

        //Update advantages
        $plan->advantages()->detach();
        if(!empty($inputs['advantages']))
        {
            foreach($inputs['advantages'] as $id_plan_advantage)
            {
                $plan->advantages()->attach($id_plan_advantage);
            }
        }
        unset($inputs['advantages']);
        $plan->update($inputs);
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
		$model->name = $inputs['name'];
        $model->description = $inputs['description'];
        $model->price = $inputs['price'];
        $model->notes = !empty($inputs['notes']) ? $inputs['notes'] : null ;
        $model->order_meal = isset($inputs['order_meal']);
        $model->reserve = isset($inputs['reserve']);

        $model->save();

        $model->advantages()->detach();
        if(!empty($inputs['advantages']))
        {
            foreach($inputs['advantages'] as $id_plan_advantage)
            {
                $model->advantages()->attach($id_plan_advantage);
            }
        }

		return $model->id_plan;
	}

}