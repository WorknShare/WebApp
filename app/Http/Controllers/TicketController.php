<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Repositories\TicketRepository;

class TicketController extends Controller
{
    
	private $ticketRepository;
    private $amountPerPage = 10;

    /**
     * Create a new SiteController instance
     *
     * @param App\Repositories\TicketRepository $ticketRepository
     * @return void
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
        //$this->middleware('access:2', ['except' => ['index','show']]);
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
            $tickets = $this->ticketRepository->getWhereWithRelations($request->search, $this->amountPerPage);
            //return request
        }
        else
        {
        	//$test = new \App\Repositories\EquipmentTypeRepository(new \App\EquipmentType());
        	//$tickets = $test->getPaginateSelect($this->amountPerPage,['name AS description', 'id_equipment_type as id']);
            $tickets = $this->ticketRepository->getPaginate($this->amountPerPage);
            return response()->json([
            	"data" => [
            		"tickets" => $tickets->items(),
            		"paginator" => [
            			"currentPage" => $tickets->currentPage(),
            			"perPage" => $tickets->perPage(),
            			"lastPage" => $tickets->lastPage()
            		]
				]
            ]);
        }
    }

}
