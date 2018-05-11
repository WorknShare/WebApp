<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use View;
use DateTime;
use App\Site;
use App\ReserveRoom;
use Illuminate\Http\Request;
use App\Http\Requests\ReserveRoomRequest;
use App\Http\Requests\SearchRequest;
use App\Repositories\ReserveRoomRepository;
use Carbon\Carbon;
use App\Jobs\SendReserveRoomCanceledMail;

class ReserveRoomController extends Controller
{


    private $reserveRoomRepository;
    private $amountPerPage = 10;

    /**
     * Create a new ReserveRoomController instance
     *
     * @param App\Repositories\ReserveRoomRepository $reserveRoomRepository
     * @return void
     */
    public function __construct(ReserveRoomRepository $reserveRoomRepository)
    {
        $this->reserveRoomRepository = $reserveRoomRepository;
        $this->middleware('auth:web', ['except' => ['indexAdmin', 'showAdmin', 'destroyAdmin']]);
        $this->middleware('password', ['only' => ['indexAdmin', 'showAdmin', 'destroyAdmin']]);
        $this->middleware('auth:admin', ['only' => ['indexAdmin', 'showAdmin', 'destroyAdmin']]);
        $this->middleware('plan.access:reserve', ['except' => ['indexAdmin', 'showAdmin', 'destroyAdmin', 'indexHistory']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $sites = Site::paginate($this->amountPerPage);
        $links = $sites->render();
        return view('order.index', compact('user', 'sites', 'links'));
    }

    public function indexHistory(Request $request)
    {
      $user = Auth::user();
      $orders = $user->getModel()->reserves()->join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                             ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                             ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name')
                                             ->orderBy('date_start', 'desc')
                                             ->paginate($this->amountPerPage);

     $meals = $user->getModel()->orderMeals()->join('meals', 'client_meal_orders.id_meal', '=', 'meals.id_meal')
                                              ->join('sites', 'sites.id_site', '=', 'client_meal_orders.id_site')
                                              ->select('client_meal_orders.*', 'meals.name as meal_name', 'meals.price as meal_price','sites.name as site_name')
                                              ->orderBy('hour', 'desc')
                                              ->paginate($this->amountPerPage);

      if ($request->ajax()) {
        if(Input::get('resource') == 'order'){
          return response()->json(View::make('order.order_history', compact('orders'))->render());
        }

        if(Input::get('resource') == 'meal'){
          return response()->json(View::make('order.meal_history', compact('meals'))->render());
        }
      }
      return View::make('order.history', compact('meals', 'orders'))->render();
    }

    public function indexAdmin(SearchRequest $request)
    {

      if(!empty($request->search))
      {
          $search = '%'.strtolower($request->search).'%';
          $orders = ReserveRoom::join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                ->join('clients', 'clients.id_client', '=', 'reserve_room.id_client')
                                ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name', 'clients.name as client_name', 'clients.surname as client_surname')
                                ->whereRaw('LOWER(command_number) LIKE ?', array($search))
                                ->orderBy('date_start', 'desc')
                                ->take($this->amountPerPage)
                                ->get();
          $links = '';
      }
      else
      {
          //$orders = $this->reserveRoomRepository->getPaginate($this->amountPerPage);
          $orders = ReserveRoom::join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                ->join('clients', 'clients.id_client', '=', 'reserve_room.id_client')
                                ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name', 'clients.name as client_name', 'clients.surname as client_surname')
                                ->orderBy('date_start', 'desc')
                                ->paginate($this->amountPerPage);

          $links = $orders->render();
      }
      return view('admin.orders.index', compact('orders', 'links'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $id_site = input::get('site');
      $user = Auth::user();
      $site = Site::find($id_site);
      $rooms = $site->rooms()->join('room_types', 'rooms.id_room_type', '=', 'room_types.id_room_type')->select('rooms.*', 'room_types.name as room_type')->where([['rooms.is_deleted','=',0], ['room_types.is_deleted','=',0]])->get();
      return view('order.create', compact('user','site', 'rooms'));
    }

    public function getEquipment($type, $id_site)
    {
      if(!is_numeric($type) || !is_numeric($id_site)) abort(404);
      \Debugbar::info($type, $id_site);
      $type = \App\EquipmentType::findOrFail($type);
      \Debugbar::info('test'.$type);
      $equipments = $type->equipment()->join('sites', 'sites.id_site', '=', 'equipment.id_site')
                                      ->where([['equipment.is_deleted','=',0], ['sites.id_site','=',$id_site]])
                                      ->get();
      foreach ($equipments as $key => $equipment) {
        if(!$equipment->isAvailable()){
          unset($equipments[$key]);
        }
      }
      return response()->json([
          'equipments' => $equipments,
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ReserveRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReserveRoomRequest $request)
    {

      $checkSchedules = false;
      $checkAvailableItems = true;
      if(isset($request->equipments)){
        $reserveEquipments = array();
        foreach ($request->equipments as $key => $equipment) {
          $reserveEquipments[] = \App\equipment::findOrFail($equipment)->reserve()->get();
        }
        $start = new DateTime($request->date.' '.$request->hour_start);
        $end = new DateTime($request->date.' '.$request->hour_end);

        foreach ($reserveEquipments as $key => $reserveEquipment) {
          foreach ($reserveEquipment as $key => $reserve) {
            $reserveStart = new DateTime($reserve->date_start);
            $reserveEnd = new DateTime($reserve->date_end);
            if( $start >= $reserveStart && $start <= $reserveEnd || $end >= $reserveStart && $end <= $reserveEnd){
              $checkAvailableItems = false;
              break;
            }
          }
        }
        if(!$checkAvailableItems) return back()->with('schedules', 'un ou plusieurs des appreils demandés ne sont pas disponible !');
      }

      $exist_orders = $this->reserveRoomRepository->getModel()->whereBetween('date_start', [$request->date.' '.$request->hour_start, $request->date.' '.$request->hour_end])
                                                              ->whereBetween('date_end', [$request->date.' '.$request->hour_start, $request->date.' '.$request->hour_end])
                                                              ->where([['is_deleted', 0], ['id_room', $request->id_room]])->get();
      if(count($exist_orders)) return back()->with('exist_order', 'Il y a déja une réservation pendant les horaires choisis ! Regardez le calendrier en dessous pour connaître les disponiblités de la salle');

      $date_start = new DateTime($request->date.' '.$request->hour_start);
      $date_end = new DateTime($request->date.' '.$request->hour_end);
      $day = $date_start->format('w');
      $day = $day == 0? 6: $day - 1;
      $schedules = \App\Schedule::where('day', $day)->get();

      foreach ($schedules as $key => $schedule) {
        $check_opening = ($schedule->hour_opening <= $request->hour_start && $schedule->hour_closing >= $request->hour_start);
        $check_closing = ($schedule->hour_opening <= $request->hour_end && $schedule->hour_closing >= $request->hour_end);
        if($check_opening && $check_closing){
          $checkSchedules = true;
          break;
        }
      }
      if(!$checkSchedules) return back()->with('schedules', 'Les heures selectionnées ne sont pas comprises dans les horaires du site');


      $reserve = $this->reserveRoomRepository->store($request->all());
      return redirect('myaccount')->withOk("La réservation n°" . $reserve->command_number . " a bien été enregistrée.");
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

        $user = Auth::user();

        $order = Auth::user()->reserves()->getModel()->join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                                          ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                                          ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name')
                                                          ->orderBy('date_start', 'desc')
                                                          ->findOrFail($id);

        $equipments = $this->reserveRoomRepository->getModel()->findOrFail($id)->equipments()
                                                                ->join('equipment_types', 'equipment.id_equipment_type', '=', 'equipment_types.id_equipment_type')
                                                                ->select('equipment.*', 'equipment_types.name')
                                                                ->get();


        return view('order.show', compact('order', 'equipments'));
    }

    public function showAdmin($id)
    {
      if(!is_numeric($id)) abort(404);
      $order = $this->reserveRoomRepository->getModel()
                                           ->join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                           ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                           ->join('clients', 'clients.id_client', '=', 'reserve_room.id_client')
                                           ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name', 'clients.name as client_name', 'clients.surname as client_surname')
                                           ->where('id_reserve_room', '=', $id)
                                           ->get()[0];

      $equipments = $this->reserveRoomRepository->getById($id)
                                                ->equipments()
                                                ->join('equipment_types', 'equipment.id_equipment_type', '=', 'equipment_types.id_equipment_type')
                                                ->select('equipment.*', 'equipment_types.name')
                                                ->get();

      return view('admin.orders.show', compact('order', 'equipments'));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAdmin($id)
    {
      if(!is_numeric($id)) abort(404);

      $order = $this->reserveRoomRepository->getById($id);
      $user = \App\User::findOrFail($order->id_client);
      $this->reserveRoomRepository->destroy($id);

      $emailJob = (new SendPaymentMailJob($user, $order, "La résevation a été suprimé par un administrateur veuillez nous contacter pour plus d'informations."))->delay(Carbon::now()->addSeconds(3));
      dispatch($emailJob);

      return redirect('admin/order')->withOk("La réservation n°" . $order->command_number . " a été supprimée.");
    }

    public function destroy($id)
    {
      if(!is_numeric($id)) abort(404);
      $user = Auth::user();
      $reserve = $user->getModel()->reserves()->findOrFail($id);
      $this->reserveRoomRepository->destroy($id);

      $emailJob = (new SendReserveRoomCanceledMail($user, $reserve, "Vous avez annulé la réservation. Si ce n'est pas vous veuillez nous contacter et changer votre mot de passe."))->delay(Carbon::now()->addSeconds(3));
      dispatch($emailJob);

      return response()->json("La réservation n°" . $reserve->orderNumber . " a été supprimée.");
    }
}
