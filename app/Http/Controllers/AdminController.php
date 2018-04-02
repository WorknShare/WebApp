<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AjaxRequest;
use App\Http\Requests\MetricsRequest;

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
     * Returns the raw data for plans relations with clients
     *
     * @param \App\Http\Requests\AjaxRequest
     * @return \Illuminate\Http\Response
     */
    public function metricsPlan(AjaxRequest $request)
    {
        $plans = \App\Plan::withCount('users')->get(["plan_id","name","clients_count"]);
        return response()->json([
            'plans' => $plans
        ]);
    }
} 
