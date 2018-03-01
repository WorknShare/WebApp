<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\PlanAdvantageRequest;
use App\Repositories\PlanAdvantageRepository;

class PlanAdvantageController extends Controller
{

    private $planAdvantageRepository;
    private $amountPerPage = 10;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advantages = $this->planAdvantageRepository->getPaginate($this->amountPerPage);
        $links = $advantages->render();
        return view('admin.planadvantage.index', compact('advantages', 'links'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Plan\PlanAdvantageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanAdvantageRequest $request)
    {
        $planAdvantage = $this->planAdvantageRepository->store($request->all());
        return response()->json([
            'id' => $planAdvantage->id_plan_advantage,
            'description' => $planAdvantage->description,
            'token' => csrf_token()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Plan\PlanAdvantageRequest $request
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
