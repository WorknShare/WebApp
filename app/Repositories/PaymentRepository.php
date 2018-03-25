<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Payment;
use DateTime;
use DateInterval;

class PaymentRepository extends ResourceRepository
{

	/**
     * Create a new repository instance.
     *
     * @param \App\Payment $model 
     * @return void
     */
  	public function __construct(Payment $model)
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
        $model->name = $inputs['name'];
        $model->surname = $inputs['surname'];
        $model->phone = $inputs['phone'];
        $model->address = $inputs['address'];
        $model->city = $inputs['city'];
        $model->postal = $inputs['postal'];

        $model->credit_card_number = $inputs['credit_card_number'];
        $model->csc = $inputs['csc'];

        $dateExpiration = new DateTime($inputs['exp_year'].'-'.$inputs['exp_month'].'-01');
        $model->expiration = $dateExpiration->format("Y-m-d");      
        
        if(!empty($inputs['limit_date']))
        {
            $model->limit_date = $inputs['limit_date'];
        }
        else 
        {
            $dateLimit = new DateTime('now');
            $dateLimit->add(new DateInterval('P1M'));
            $model->limit_date = $dateLimit->format("Y-m-d H:i:s");
        }

        $faker = \Faker\Factory::create();
        $model->command_number = $faker->uuid;

        $model->id_client = Auth::user()->id_client;
        $model->id_plan = $inputs['id_plan'];

        $model->save();
		return $model->id_history;
	}

}