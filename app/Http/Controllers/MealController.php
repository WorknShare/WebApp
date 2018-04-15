<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MealRequest;
use App\Repositories\MealRepository;
use App\Http\Requests\SearchRequest;

class MealController extends Controller
{

  private $mealRepository;
  private $amountPerPage = 10;

  /**
  * Create a new $typeOfRoomController instance
  *
  * @param App\Repositories\MealRepository $mealRepository
  * @return void
  */
  public function __construct(MealRepository $mealRepository)
  {
    $this->mealRepository = $mealRepository;
    $this->middleware('auth:admin');
    $this->middleware('password');
    $this->middleware('access:2', ['except' => ['index','show']]);
  }
    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {

      if(!empty($request->search))
      {
          $search = '%'.strtolower($request->search).'%';
          $meals = $this->mealRepository->getWhere('name',$search);
          $links = '';
      }
      else
      {
          $meals = $this->mealRepository->getPaginate($this->amountPerPage);
          $links = $meals->render();
      }
      return view('admin.meal.index', compact('meals', 'links'));
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

        $meal = $this->mealRepository->getById($id);

        return view('admin.meal.show', compact('meal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.meal.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  app\Http\Requests\MealRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealRequest $request)
    {
      $meal = $this->mealRepository->store($request->all());
      return redirect('admin/meal')->withOk("Le repas a été créé.");

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
       if(!is_numeric($id)) abort(404);
       $meal = $this->mealRepository->getById($id);
       return view('admin.meal.edit', compact('meal'));

     }

    /**
     * Update the specified resource in storage.
     *
     * @param  app\Http\Requests\MealRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MealRequest $request, $id)
    {
      if(!is_numeric($id)) abort(404);
      $this->mealRepository->update($id, $request->all());
      return redirect('admin/meal')->withOk("Le repas " . $request->input('name') . " a été modifié.");
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
      $meal = $this->mealRepository->getById($id)->name;
      $orders = $this->mealRepository->getById($id)->reserve()->where('is_deleted', '=', 0)->get();

      foreach ($orders as $key => $order) {
        $model = \App\ReserveMeal::findOrFail($order->id_order_meal);
        $model->is_deleted = true;
        $model->save();
      }

      $this->mealRepository->destroy($id);
      return redirect('admin/meal')->withOk("Le repas " . $meal . " a été supprimé.");
    }

}
