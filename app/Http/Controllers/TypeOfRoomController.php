<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\room\TypeOfRoomRequest;
use App\Repositories\TypeOfRoomRepository;


class TypeOfRoomController extends Controller
{

    private $typeOfRoomRepository;
    private $amountPerPage = 10;

    /**
    * Create a new $typeOfRoomController instance
    *
    * @param App\Repositories\TypeOfRoomRepository $typeOfRoomRepository
    * @return void
    */
    public function __construct(TypeOfRoomRepository $typeOfRoomRepository)
    {
      $this->typeOfRoomRepository = $typeOfRoomRepository;
      $this->middleware('auth:admin');
      $this->middleware('password');
      $this->middleware('access:2', ['only' => ['store', 'update', 'destroy']]);
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
      $typeOfRooms = $this->typeOfRoomRepository->getPaginateSelect($this->amountPerPage, ["name as description", "id_room_type as id"]);

      if ($typeOfRooms->isEmpty() && $typeOfRooms->currentPage() != 1)
      {
        return abort(404);
      }

      $links = $typeOfRooms->render();
      return view('admin.typeOfRooms.index', compact('typeOfRooms', 'links'));
    }



    /**
    * Store a newly created resource in storage.
    *
    * @param  App\Http\Requests\room\TypeOfRoomRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(TypeOfRoomRequest $request)
    {
      $typeOfRoom = $this->typeOfRoomRepository->store($request->all());
      $links = $this->typeOfRoomRepository->getPaginate($this->amountPerPage)->render();

      return response()->json([
          'id' => $typeOfRoom->id_room_type,
          'description' => $typeOfRoom->name,
          'token' => csrf_token(),
          'links' => $links->toHtml()
      ]);
    }


    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\TypeOfRoomRequest  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(TypeOfRoomRequest $request, $id)
    {
      if(!is_numeric($id)) abort(404);

      $this->typeOfRoomRepository->update($id, $request->all());

      return response()->json([
          'text' => $request->name
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
      $this->typeOfRoomRepository->destroy($id);

      $typeOfRoom = $this->typeOfRoomRepository->getPaginateSelect($this->amountPerPage, ['id_room_type as id','name as description']);
      $typeOfRoom->setPath(route('typeOfRooms.index'));
      $links = $typeOfRoom->render();

      return response()->json([
          'url'        => route('typeOfRooms.index'),
          'links'      => $links->toHtml(),
          'token'      => csrf_token(),
          'resources' => $typeOfRoom->items()
      ]);
    }
}
