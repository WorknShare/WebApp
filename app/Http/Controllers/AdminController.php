<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AjaxRequest;
use App\Http\Requests\MetricsRequest;
use App\MetricsBuilder;
use DateTime;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('password');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    /**
     * Returns the raw data for plans relations with clients at the current time
     *
     * @param \App\Http\Requests\AjaxRequest
     * @return \Illuminate\Http\Response
     */
    public function metricsPlanPie(AjaxRequest $request)
    {
        $plans = \App\Plan::select(["id_plan","name"])->withCount('users')->get();
        return response()->json([
            'plans' => $plans
        ]);
    }

    /**
     * Returns data for plans relations with clients along requested time
     *
     * @param \App\Http\Requests\MetricsRequest
     * @return \Illuminate\Http\Response
     */
    public function metricsPlan(MetricsRequest $request)
    {
        
        $metrics = new MetricsBuilder($request->date_start, $request->date_end, 'plans');
        $plans = $metrics->select('count(history.id_plan) as count, plans.name')
                         ->with('history', 'plans.id_plan', 'history.id_plan')
                         ->column('history.created_at')
                         ->duration('history.limit_date')
                         ->groupBy('plans.id_plan')
                         ->getData();
        $labels = $metrics->getLabels();

        return response()->json([
            'labels' => $labels,
            'datasets' => $plans
        ]);
    }

    /**
     * Returns data for reservations count along requested time
     *
     * @param \App\Http\Requests\MetricsRequest
     * @return \Illuminate\Http\Response
     */
    public function metricsReserve(MetricsRequest $request)
    {
        
        $metrics = new MetricsBuilder($request->date_start, $request->date_end, 'reserve_room');
        $plans = $metrics->select('count(*) as count, "Réservations" as name')
                         ->column('date_start')
                         ->duration('date_end')
                         ->getData();
        $labels = $metrics->getLabels();

        return response()->json([
            'labels' => $labels,
            'datasets' => $plans
        ]);
    }

    private function generateLabels($date_start, $date_end)
    {
        $date_start = new DateTime($date_start);
        $date_end = new DateTime($date_end);
        $diff = $date_start->diff($date_end, true);
    }
} 
