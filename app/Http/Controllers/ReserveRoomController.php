<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\Site;
use Illuminate\Http\Request;
use App\Http\Requests\ReserveRoomRequest;
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
        $sites = Site::paginate($this->amountPerPage);
        $links = $sites->render();
        return view('order.index', compact('user', 'sites', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $id_site = input::get('site');
      $site = SIte::find($id_site);
      $rooms = $site->rooms()->join('room_types', 'rooms.id_room_type', '=', 'room_types.id_room_type')->select('rooms.*', 'room_types.name as room_type')->where('rooms.is_deleted','=',0)->get();
      return view('order.create', compact('site', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ReserveRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReserveRoomRequest $request)
    {
      $reserve = $this->$reserveRoomRepository->store($request->all());
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
        $order = Auth::user()->reserves()->findOrFail($id);
        $equipment = $order->equipment()->join('equipment_types', 'equipment.id_equipment_type', '=', 'equipment_types.id_equipment_type')->select('equipment.*', 'equipment_types.name')->get();
        return view('order.show', compact('user', 'order', '$equipment'));
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
      $orderNumber = Auth::user()->reserves()->findOrFail($id)->command_number;
      $this->reserveRoomRepository->destroy($id);
      return redirect('order')->withOk("La réservation n°" . $orderNumber . " a été supprimée.");
    }
}
