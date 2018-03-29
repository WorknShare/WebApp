<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Http\Requests\Employee\EmployeeUpdatePasswordRequest;
use App\Repositories\EmployeeRepository;

use Illuminate\Support\Facades\Auth;

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
        $this->middleware('password', ['except' => ['editPasswordPrompt', 'updatePassword']]);
        $this->middleware('access:1', ['only' => ['create', 'store', 'destroy']]);
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
            $employees = $this->employeeRepository->getSearch($request->search, $this->amountPerPage);
            $links = '';
        }
        else
        {
            $employees = $this->employeeRepository->getPaginate($this->amountPerPage);
            $links = $employees->render();
        }
        return view('admin.employee.index', compact('employees', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\Employee\EmployeeCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeCreateRequest $request)
    {
        $request['phone'] = str_replace(' ', '', $request['phone']);
        $employee = $this->employeeRepository->store($request->all());
        return redirect('admin/employee')->withOk("L'employé " . $employee->surname . ' ' . $employee->name . " a été créé.");
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
        $employee = $this->employeeRepository->getById($id);
        return view('admin.employee.show', compact('employee'));
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
        if(Auth::user()->role != 1 && Auth::user()->id_employee != $id) abort(403);
        $employee = $this->employeeRepository->getById($id);
        return view('admin.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\Employee\EmployeeUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);
        if(Auth::user()->role != 1 && Auth::user()->id_employee != $id) abort(403);

        $request['phone'] = str_replace(' ', '', $request['phone']);
        $this->employeeRepository->update($id, Auth::user()->role == 1 ? $request->all() : $request->except(['role']));
        return redirect('admin/employee/'.$id)
            ->withOk(Auth::user()->id_employee == $id ? 
                "Votre profil a été modifié." :
                "L'employé " . $request->input('surname') . ' ' . $request->input('name') . " a été modifié.");
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
        if($id == Auth::user()->id_employee) abort(403);
        $employee = $this->employeeRepository->getById($id);
        $name = $employee->surname . ' ' . $employee->name;
        $this->employeeRepository->destroy($id);
        return redirect('admin/employee')->withOk("L'employé " . $name . " a été supprimé.");
    }

    /**
     * Show the form for editing the password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPasswordPrompt($id)
    {
        if(Auth::user()->id_employee == $id)
            return view('admin.employee.edit_password_prompt', compact('id'));
        else abort(403);
    }

    /**
     * Show the form for editing the password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id)
    {
        if(Auth::user()->role == 1 || Auth::user()->id_employee == $id) {
            $employee = $this->employeeRepository->getById($id);
            return view('admin.employee.edit_password', compact('employee'));
        }
        else abort(403);
    }

    /**
     * Update the password specified resource in storage.
     *
     * @param  \App\Http\Request\Employee\EmployeeUpdatePasswordRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(EmployeeUpdatePasswordRequest $request, $id)
    {
        $employee = $this->employeeRepository->getById($id);

        if(Auth::user()->id_employee == $id)
        {
            $this->employeeRepository->update($id, ["password"=>$request->password, "changed_password" => true]);
            return redirect('admin/employee/'.$id)->withOk("Votre mot de passe a été modifié.");
        }
        else if(Auth::user()->role == 1)
        {
            $this->employeeRepository->update($id, ["password"=>$request->password, "changed_password" => false]);
            return redirect('admin/employee/'.$id)->withOk("Le mot de passe de l'employé " . $employee->surname . ' ' . $employee->name . " a été modifié.");
        }
        else abort(403);
    }
}
