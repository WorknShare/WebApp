<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AjaxRequest;
use App\Http\Requests\MetricsRequest;
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
        
        $plans = \App\Payment::with('plan')->whereDate('created_at', '>=', $request->date_start)->whereDate('created_at', '<=', $request->date_end)->get();

        //$labels = $this->generateLabels($request->date_start, $request->date_end);
        return response()->json([
            'labels' => ['label'],
            'plans' => $plans
        ]);
    }

    private function generateLabels($date_start, $date_end)
    {
        $date_start = new DateTime($date_start);
        $date_end = new DateTime($date_end);
        $diff = $date_start->diff($date_end, true);
    }
} 
