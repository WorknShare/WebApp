<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{

    private $employeeRepository;
    private $amountPerPage = 10;

    /**
     * Create a new EmployeeController instance
     * 
     * @param \App\Repositories\EmployeeRepository $employeeRepository
     * @return void
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        //TODO access levels
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        if(!empty($request->search))
        {
            $search = '%'.strtolower($request->search).'%';
            $employees = $this->employeeRepository->getModel()->whereRaw('LOWER(email) LIKE ? OR LOWER(name) LIKE ? OR LOWER(surname) LIKE ?', array($search,$search,$search))->take($this->amountPerPage)->get();
            $links = '';
            return view('admin.employee.index', compact('employees', 'links'));
        }
        else
        {
            $employees = $this->employeeRepository->getPaginate($this->amountPerPage);
            $links = $employees->render();
            return view('admin.employee.index', compact('employees', 'links'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
