<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository;
use App\Repositories\PlanAdvantageRepository;

use App\Http\Requests\Plan\PlanRequest;

class PlanController extends Controller
{

    private $planRepository;
    private $planAdvantageRepository;
    private $amountPerPage = 10;

    /**
     * Create a new PlanController instance
     * 
     * @param App\Repositories\PlanRepository $planRepository
     * @param App\Repositories\PlanAdvantageRepository $planAdvantageRepository
     *
     * @return void
     */
    public function __construct(PlanRepository $planRepository, PlanAdvantageRepository $planAdvantageRepository)
    {
        $this->planRepository = $planRepository;
        $this->planAdvantageRepository = $planAdvantageRepository;
        $this->middleware('auth:admin', ['except' => ['indexPublic']]); //Requires admin permission
        //TODO access levels
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = $this->planRepository->getPaginate($this->amountPerPage);
        $links = $plans->render();
        $advantagesCount = DB::table('plan_advantages')->count(); //Used to display info alert if no advantage exist
        return view('admin.plans.index', compact('plans', 'links', 'advantagesCount'));
    }

    /**
     * Display a public comparative listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublic()
    {
        $plans = \App\Plan::with('advantages')->withCount('advantages')->orderBy('advantages_count', 'asc')->get();
        $planAdvantages = \App\PlanAdvantage::withCount('plans')->orderBy('plans_count', 'desc')->orderBy('id_plan_advantage', 'asc')->get();
        return view('plans_index', compact('plans', 'planAdvantages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advantages = $this->planAdvantageRepository->getAll();
        if($advantages->count() <= 0)
            return redirect('admin/planadvantage')->withInfo('Aucun avantage de forfait n\'a été créé. Vous devez <a href="' . route('planadvantage.index') . '">créer des avantages de forfait</a> avant de pouvoir créer un forfait.');
        else
            return view('admin.plans.create', compact('advantages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Plan\PlanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        $plan = $this->planRepository->store($request->all());
        return redirect('admin/plan')->withOk("Le forfait " . $plan->name . " a été créé.");
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
        $plan = $this->planRepository->getById($id);
        $advantages = $plan->advantages()->get(['description']);
        return view('admin.plans.show', compact('plan', 'advantages'));
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
        $plan = $this->planRepository->getById($id);
        $plan_advantages = $plan->advantages()->pluck('plan_advantages.id_plan_advantage')->toArray();
        $advantages = $this->planAdvantageRepository->getAll();
        return view('admin.plans.edit', compact('plan', 'plan_advantages', 'advantages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Plan\PlanRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);

        $this->planRepository->update($id, $request->all());
        return redirect('admin/plan/'.$id)->withOk("Le forfait " . $request->input('name') . " a été modifié.");
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
        $plan = $this->planRepository->getById($id)->name;
        $this->planRepository->destroy($id);
        return redirect('admin/plan')->withOk("Le forfait " . $plan . " a été supprimé.");
    }
}
