<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository;
use App\Repositories\PlanAdvantageRepository;
use App\Http\Requests\PlanPaymentRequest;
use App\Repositories\PaymentRepository;
use App\Http\Requests\Plan\PlanRequest;
use App\Plan;
use App\PlanAdvantage;

use DateTime;
use DateInterval;

class PlanController extends Controller
{

    private $planRepository;
    private $planAdvantageRepository;
    private $paymentRepository;
    private $amountPerPage = 10;

    /**
     * Create a new PlanController instance
     * 
     * @param \App\Repositories\PlanRepository $planRepository
     * @param \App\Repositories\PlanAdvantageRepository $planAdvantageRepository
     * @param \App\Repositories\PaymentRepository $paymentRepository
     *
     * @return void
     */
    public function __construct(PlanRepository $planRepository, PlanAdvantageRepository $planAdvantageRepository, PaymentRepository $paymentRepository)
    {
        $this->planRepository = $planRepository;
        $this->planAdvantageRepository = $planAdvantageRepository;
        $this->paymentRepository = $paymentRepository;
        $this->middleware('auth:admin', ['except' => ['indexPublic','choose','payment','paymentSend', 'planHistory']]); //Requires admin permission
        $this->middleware('password', ['except' => ['indexPublic','choose','payment','paymentSend', 'planHistory']]);
        $this->middleware('access:1', ['except' => ['index','show','indexPublic','choose','payment','paymentSend', 'planHistory']]);
        $this->middleware('auth:web', ['only' => ['choose','payment','paymentSend', 'planHistory']]);
        $this->middleware('plan.valid', ['only' => ['choose','payment','paymentSend', 'planHistory']]);
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
        $plans = Plan::with('advantages')->where('is_deleted','=',0)->orderBy('price', 'asc')->get();
        $planAdvantages = PlanAdvantage::withCount('plans')->orderBy('plans_count', 'desc')->orderBy('id_plan_advantage', 'asc')->get();
        $orderMealCount = Plan::where([['order_meal', '=', 1],['is_deleted', '=', 0]])->count();
        $reserveCount = Plan::where([['reserve', '=', 1],['is_deleted', '=', 0]])->count();
        return view('welcome', compact('plans', 'planAdvantages', 'orderMealCount', 'reserveCount'));
    }

    /**
     * Show the public comparative listing of the resource with choose buttons
     *
     * @return \Illuminate\Http\Response
     */
    public function choose()
    {
        $plans = Plan::with('advantages')->where('is_deleted','=',0)->orderBy('price', 'asc')->get();
        $planAdvantages = PlanAdvantage::withCount('plans')->orderBy('plans_count', 'desc')->orderBy('id_plan_advantage', 'asc')->get();
        $orderMealCount = Plan::where([['order_meal', '=', 1],['is_deleted', '=', 0]])->count();
        $reserveCount = Plan::where([['reserve', '=', 1],['is_deleted', '=', 0]])->count();
        return view('myaccount.plans', compact('plans', 'planAdvantages', 'orderMealCount', 'reserveCount'));
    }

    /**
     * Show the payment form
     *
     * @return \Illuminate\Http\Response
     */
    public function payment($id)
    {
        $plan = $this->planRepository->getById($id);
        $userPlan =  Auth::user()->plan()->first();
        $showWarning = isset($userPlan) && $userPlan->id_plan != $id;
        return view('myaccount.plan_payment', compact('plan', 'showWarning'));
    }

    /**
     * Create an order
     *
     * @param  \App\Http\Requests\PlanPaymentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentSend(PlanPaymentRequest $request, $id)
    {
        if(!$this->planRepository->exists($id)) abort(404);
        $user = Auth::user();
        $plan = $user->plan()->first();

        $request->merge(['id_plan' => $id]);
        $last = $user->lastPayment();
        $dateNow = date("Y-m-d H:i:s");

        if(!empty($last))
        {
            if(!empty($plan) && $plan->id_plan == $id) 
            {
                //Renew

                //New command
                $limitDate = new DateTime($last->limit_date);
                $limitDate->add(new DateInterval('P1M'));
                $request->merge(['limit_date' => $limitDate->format('Y-m-d H:i:s')]);

                //Last command set limit date to now
                $last->limit_date = $dateNow;
            }
            else
            {
                //Changed plan
                //Last command set limit date to now
                $last->limit_date = $dateNow;
            }
            $last->save();
        }

        $request['phone'] = str_replace(' ', '', $request['phone']);
        $payment = $this->paymentRepository->store($request->all());

        $user->id_plan = $id;
        $user->save();
        return redirect('paymentaccepted')->with('commandNumber', $payment->command_number);
    }

    /**
     * Show the plan payment history of the current user
     *
     * @return \Illuminate\Http\Response
     */
    public function planHistory()
    {
        $user = Auth::user();
        $payments = $user->payments()->with('plan')->orderBy('created_at','desc')->paginate($this->amountPerPage);
        $links = $payments->render();
        return view('myaccount.plan_history', compact('user', 'payments', 'links'));
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

        if(!$request->has('order_meal')) { $request->merge(['order_meal' => 0]); }
        if(!$request->has('reserve')) { $request->merge(['reserve' => 0]); }

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
