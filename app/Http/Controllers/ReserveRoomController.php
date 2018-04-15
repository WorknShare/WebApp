<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use View;
use App\Site;
use App\ReserveRoom;
use Illuminate\Http\Request;
use App\Http\Requests\ReserveRoomRequest;
use App\Http\Requests\SearchRequest;
use App\Repositories\ReserveRoomRepository;

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

    public function getEquipment($id)
    {
      if(!is_numeric($id)) abort(404);
      $type = \App\EquipmentType::findOrFail($id);
      $equipments = $type->equipment()->where('is_deleted','=',0)->get();
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

      $reserve = $this->reserveRoomRepository->store($request->all());
      dd('test');
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
        if(!is_numeric($id)) abort(404);
        $user = Auth::user();
        $order = Auth::user()->reserves()->getModel()->join('rooms', 'reserve_room.id_room', '=', 'rooms.id_room')
                                                          ->join('sites', 'sites.id_site', '=', 'rooms.id_site')
                                                          ->select('reserve_room.*', 'rooms.name as room_name', 'sites.name as site_name')
                                                          ->orderBy('date_start', 'desc')
                                                          ->findOrFail($id);

        $equipments = $this->reserveRoomRepository->getbyId($id)->equipments()
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
      $orderNumber = $this->reserveRoomRepository->getById($id)->command_number;
      $this->reserveRoomRepository->destroy($id);
      return redirect('admin/order')->withOk("La réservation n°" . $orderNumber . " a été supprimée.");
    }

    public function destroy($id)
    {
      if(!is_numeric($id)) abort(404);
      $user = Auth::user();
      $orderNumber = $user->getModel()->reserves()->findOrFail($id)->command_number;
      $this->reserveRoomRepository->destroy($id);
      return response()->json("La réservation n°" . $orderNumber . " a été supprimée.");
    }
}
