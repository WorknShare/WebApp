<?php

namespace App\Http\Controllers;

use App\Requests\Plan\PlanAdvantageRequest;

class PlanAdvantageController extends Controller
{

    private $planAdvantageRepository;

    /**
     * Create a new PlanAdvantageController instance
     * 
     * @param App\Repositories\PlanAdvantageRepository $planAdvantageRepository
     * @return void
     */
    public function __construct(PlanAdvantageRepository $planAdvantageRepository)
    {
        $this->planAdvantageRepository = $planAdvantageRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        //TODO access levels
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Requests\Plan\PlanAdvantageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanAdvantageRequest $request)
    {
        $planAdvantage = $this->planAdvantageRepository->store($request->all());
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Requests\Plan\PlanAdvantageRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanAdvantageRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);
        $this->planAdvantageRepository->update($id, $request->all());
        return response()->json();
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
        $this->planAdvantageRepository->destroy($id);
        return response()->json();
    }
}
