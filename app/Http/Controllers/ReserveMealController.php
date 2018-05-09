<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use View;
use DB;
use DateTime;
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
      $this->middleware('plan.access:order_meal');
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
      $ok = false;
      $date = new DateTime($request->date.' '.$request->hour);
      $day = $date->format('w');
      $day = $day == 0? 6: $day - 1;
      $schedules = \App\Schedule::where('day', $day)->get();

      foreach ($schedules as $key => $schedule) {
        if($schedule->hour_opening <= $request->hour && $schedule->hour_closing >= $request->hour){
          $ok = true;
          break;
        }
      }
      if(!$ok) return back()->with('schedules', 'Les heures selectionnées ne sont pas comprises dans les horaires du site');

      $reserve = $this->reserveMealRepository->store($request->all());
      return redirect('myaccount')->withOk("La réservation n°" . $reserve->command_number . " a bien été enregistrée.");
    }

    public function getMeal($id)
    {
      $meal = \App\Meal::where('id_meal', '=', $id)->get()[0];
      \Debugbar::info($meal);
      return response()->json([
          'name' => $meal->name,
          'price' => $meal->price,
          'content' => $meal->menu,
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
      $user = Auth::user();
      $orderNumber = $user->getModel()->orderMeals()->findOrFail($id)->command_number;
      $this->reserveMealRepository->destroy($id);
      return response()->json("La commande n°" . $orderNumber . " a été supprimée.");


    }
}
