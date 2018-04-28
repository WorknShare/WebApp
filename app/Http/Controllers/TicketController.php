<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Ticket\TicketRequest;
use App\Http\Requests\Ticket\TicketStatusRequest;
use App\Http\Requests\Ticket\TicketAffectRequest;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    
	private $ticketRepository;
    private $amountPerPage = 20;

    /**
     * Create a new SiteController instance
     *
     * @param App\Repositories\TicketRepository $ticketRepository
     * @return void
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->middleware('access:3', ['only' => ['store']]);
        $this->middleware('access:2', ['only' => ['affect']]);
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
            $tickets = $this->ticketRepository->getWhereWithRelations($request->search, $this->amountPerPage, $request->filter);
            return response()->json([
                "data" => [
                    "items" => $tickets
                ]
            ]);
        }
        else
        {
            $tickets = $this->ticketRepository->getPaginate($this->amountPerPage, $request->filter);
            return response()->json([
            	"data" => [
            		"items" => $tickets->items(),
            		"paginator" => [
            			"currentPage" => $tickets->currentPage(),
            			"perPage" => $tickets->perPage(),
            			"lastPage" => $tickets->lastPage()
            		]
				]
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\Ticket\TicketRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $request->merge(['status' => 0]);
        $ticket = $this->ticketRepository->store($request->all());
        return response()->json([
            "id" => $ticket->id_ticket
        ], 201);
    }

    /**
     * Update the status
     *
     * @param App\Http\Requests\Ticket\TicketStatusRequest $request
     * @param int $id_ticket
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(TicketStatusRequest $request, $id_ticket)
    {
        
        if(!is_numeric($id_ticket)) abort(404);

        //Specific access levels
        if(Auth::user()->role != 1 && Auth::user()->role != 4) abort(403); 

        $ticket = $this->ticketRepository->getById($id_ticket);
        $ticket->update($request->only("status"));
        return response()->json([], 204);
    }

    /**
     * Affects the specified employee to a ticket.
     *
     * @param  \App\Http\Requests\Ticket\TicketAffectRequest $request
     * @param  int  $id_ticket
     * @return \Illuminate\Http\Response
     */
    public function affect(TicketAffectRequest $request, $id_ticket)
    {
        if(!is_numeric($id_ticket)) abort(404);

        $ticket = $this->ticketRepository->getById($id_ticket);

        if($request->employee == 0)
        {
            $ticket->employeeAssigned()->dissociate();
        }
        else
        {
            $employee = \App\Employee::find($request->employee);

            if(!is_null($employee)) 
            {
                if($employee->role == 4)
                    $ticket->employeeAssigned()->associate($request->employee);
                else
                    return response()->json(["error" => "L'employé sélectionné n'est pas un technicien."], 400);
            }
            else
                return response()->json(["error" => "L'employé sélectionné n'existe pas."], 400);
        }

        $ticket->save();

        return response()->json([], 204);
    }

}
