<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\room\RoomRequest;
use App\Repositories\RoomRepository;

class RoomController extends Controller
{


  private $roomRepository;

  /**
   * Create a new RoomController instance
   *
   * @param App\Repositories\RoomRepository $siteRepository
   * @return void
   */
  public function __construct(RoomRepository $roomRepository)
  {
      $this->roomRepository = $roomRepository;
      $this->middleware('auth:admin', ['except' => ['calendar']]);
      $this->middleware('password', ['except' => ['calendar']]);
      $this->middleware('access:2', ['only' => ['store', 'edit', 'update', 'destroy']]);
  }



    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\room\RoomRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $room = $this->roomRepository->store($request->all());
        return back()->withOk("La salle a été créé.");
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
      $room = $this->roomRepository->getById($id);
      $site = $room->site()->get()[0];
      return view('admin.rooms.show', compact('room', 'site'));
    }

    public function calendar($id)
    {
      if(!is_numeric($id)) abort(404);
      $room = $this->roomRepository->getById($id);
      $calendar = $room->reserve()->join('clients', 'reserve_room.id_client', '=', 'clients.id_client')->select('reserve_room.*', 'clients.name')->get();
      return response()->json([
          'calendar' => $calendar,
          'room' => $room->name,
      ]);
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
      $room = $this->roomRepository->getById($id);
      return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\room\RoomRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
      if(!is_numeric($id)) abort(404);
      $this->roomRepository->update($id, $request->all());
      return redirect('admin/site/'. $request->get('id_site'))->withOk("La salle " . $request->input('name') . " a été modifié.");
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
      $room = $this->roomRepository->getById($id)->name;
      $site = $this->roomRepository->getById($id)->id_site;
      $this->roomRepository->destroy($id);
      return redirect('admin/site/'. $site)->withOk("La salle " . $room . " a été supprimé.");
    }
}
