<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $this->middleware('auth:admin-api'); //Requires an api connection
        //$this->middleware('access:2', ['except' => ['index','show']]);
    }

}
