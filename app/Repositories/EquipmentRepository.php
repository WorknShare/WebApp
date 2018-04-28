<?php

namespace App\Repositories;

use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Model;
use App\Equipment;

class EquipmentRepository extends ResourceRepository
{

    protected $softDeleted = true;

	/**
     * Create a new repository instance.
     *
     * @param \App\Equipment $model
     * @return void
     */
  	public function __construct(Equipment $model)
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
		$model->serial_number = $inputs['serial_number'];
        $model->id_equipment_type = $inputs['id_equipment_type'];
        $model->save();
        return $model->id_equipment;
	}


  public function getPaginateApp($n, $filter=null)
  {
      $query = $this->model->with([
        'type' => function($query) {
          $query->select('id_equipment_type', 'name');
        },
        'site' => function($query) {
          $query->select('id_site', 'name', 'address');
        }
      ])
      ->orderBy('serial_number');

      if($filter != null)
        $query->where('id_equipment_type', '=', $filter);

      return $query->paginate($n);
  }

  public function getWhereWithRelations($value,$limit=100, $filter=null)
  {
    $search = '%'.strtolower($value).'%';

    $query = $this->model->with([
      'type' => function($query) {
        $query->select('id_equipment_type', 'name');
      },
      'site' => function($query) {
        $query->select('id_site', 'name', 'address');
      }
    ]);

    if($filter != null)
    $query->where('id_equipment_type', '=', $filter);

    $query->whereRaw('LOWER(serial_number) LIKE ?', array($search))
    ->orWhereHas('site', function($query) use ($search) {
      $query->whereRaw('LOWER(name) LIKE ?', array($search));
    });

    if($filter != null)
    $query->where('id_equipment_type', '=', $filter);

    return $query->orderBy('serial_number')->take($limit)->get();
  }

}
