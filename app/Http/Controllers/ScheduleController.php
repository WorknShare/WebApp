<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;
use App\Repositories\ScheduleRepository;
use App\Repositories\ReserveMealRepository;
use App\Repositories\ReserveRoomRepository;

class ScheduleController extends Controller
{

    private $scheduleRepository;
    private $reserveMealRepository;
    private $reserveRoomRepository;

    /**
     * Create a new ScheduleController instance
     *
     * @param App\Repositories\ScheduleRepository $scheduleRepository
     * @return void
     */
    public function __construct(ScheduleRepository $scheduleRepository, ReserveMealRepository $reserveMealRepository, ReserveRoomRepository $reserveRoomRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->reserveMealRepository = $reserveMealRepository;
        $this->reserveRoomRepository = $reserveRoomRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        $this->middleware('password');
        $this->middleware('access:2');
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
        $schedule = $this->scheduleRepository->getById($id);

        $reserves = \App\ReserveRoom::where('is_deleted', 0)->get();
        $meals = \App\ReserveMeal::where('is_deleted', 0)->get();

        foreach ($reserves as $key => $reserve) {
          $date = new DateTime($reserve->date_start);
          $day = $date->format('w');
          $day = $day == 0? 6: $day - 1;
          if($day == $schedule->day && $schedule->hour_opening <= $date->format('H:i:s') && $schedule->hour_closing >= $date->format('H:i:s')){
            if((new DateTime())->format('Y-m-d H:i:s') < $date){
              $this->reserveRoomRepository->destroy($reserve->id_reserve_room);
            }
          }
        }

        foreach ($meals as $key => $meal) {
          $date = new DateTime($meal->hour);
          $day = $date->format('w');
          $day = $day == 0? 6: $day - 1;
          if($day == $schedule->day && $schedule->hour_opening <= $date->format('H:i:s') && $schedule->hour_closing >= $date->format('H:i:s')){
            if((new DateTime())->format('Y-m-d H:i:s') < $date){
              $this->reserveMealRepository->destroy($meal->id_order_meal);
            }
          }
        }
        $this->scheduleRepository->destroy($id);
        return back()->withOk("L'horaire a été supprimé.");
    }
}
