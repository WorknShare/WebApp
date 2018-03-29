<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests\OrderMealRequest;
use App\Repositories\ReserveMealRepository;

class ReserveMealController extends Controller
{

    private $reserveMealRepository;
    private $amountPerPage = 10;

    /**
    * Create a new $typeOfRoomController instance
    *
    * @param App\Repositories\MealRepository $mealRepository
    * @return void
    */
    public function __construct(ReserveMealRepository $reserveMealRepository)
    {
      $this->reserveMealRepository = $reserveMealRepository;
      $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Auth::user();
      $sites = \App\Site::paginate($this->amountPerPage);
      $links = $sites->render();
      return view('meal.index', compact('user', 'sites', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $user = Auth::user();
      $id_site = input::get('site');
      $site = \App\Site::find($id_site);
      $meals = $site->meals()->where('is_deleted', '=', 0)->get();
      return view('meal.create', compact('user','site', 'meals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderMealRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderMealRequest $request)
    {
      $reserve = $this->reserveMealRepository->store($request->all());
      return redirect('order')->withOk("La réservation n°" . $reserve->command_number . " a bien été enregistrée.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
