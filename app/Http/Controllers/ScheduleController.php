<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;
use App\Repositories\ScheduleRepository;

class ScheduleController extends Controller
{

    private $scheduleRepository;

    /**
     * Create a new ScheduleController instance
     * 
     * @param App\Repositories\ScheduleRepository $scheduleRepository
     * @return void
     */
    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        $this->middleware('password');
        //TODO access levels
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  use App\Http\Requests\ScheduleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $schedule = $this->scheduleRepository->store($request->all());
        return back()->withOk("L'horaire a été créé.");
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
        $this->scheduleRepository->destroy($id);
        return back()->withOk("L'horaire a été supprimé.");
    }
}
