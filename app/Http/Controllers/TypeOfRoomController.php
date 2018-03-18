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
      $this->middleware('access:2', ['only' => ['store', 'update', 'destroy']]);
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
      $typeOfRooms = $this->typeOfRoomRepository->getPaginate($this->amountPerPage);

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
      return Redirect::route('typeOfRooms.index')->withOk("Le type de salle " . $typeOfRoom->name . " a été créé.");
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
      return Redirect::route('typeOfRooms.index')->withOk("Le type de salle " . $request->input('name') . " a été modifié.");
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
      $typeOfRoom = $this->typeOfRoomRepository->getById($id)->name;
      $this->typeOfRoomRepository->destroy($id);
      return Redirect::route('typeOfRooms.index')->withOk("Le site " . $typeOfRoom . " a été supprimé.");
    }
}
