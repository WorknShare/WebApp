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
        $this->middleware('password');
        $this->middleware('access:1', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advantages = $this->planAdvantageRepository->getPaginateSelect($this->amountPerPage, ['id_plan_advantage as id','description']);

        if ($advantages->isEmpty() && $advantages->currentPage() != 1)
        {
            return abort(404);
        }

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
        $links = $this->planAdvantageRepository->getPaginate($this->amountPerPage)->render();
        return response()->json([
            'id' => $planAdvantage->id_plan_advantage,
            'description' => $planAdvantage->description,
            'token' => csrf_token(),
            'links' => $links->toHtml()
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
        return response()->json([
            'text' => $request->description
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
        $this->planAdvantageRepository->destroy($id);

        $advantages = $this->planAdvantageRepository->getPaginateSelect($this->amountPerPage, ['id_plan_advantage as id','description']);
        $advantages->setPath(route('planadvantage.index'));
        $links = $advantages->render();

        return response()->json([
            'url'        => route('planadvantage.index'),
            'links'      => $links->toHtml(),
            'token'      => csrf_token(),
            'resources' => $advantages->items()
        ]);
    }
}
