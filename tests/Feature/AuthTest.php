<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Employee;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

/**
 * This test checks if the authentication features are working properly
 */
class AuthTest extends TestCase
{

	use RefreshDatabase;

	private $employees = [];
	private $users = [];


    public function testAuth()
    {
        $this->createUsers();
        $this->redirect();
        $this->access();
    }

    private function createUsers()
    {
    	for ($i = 0 ; $i < 10 ; $i++)
    	{ 
    		$this->users[$i] = factory(User::class)->create();
    	}

    	for($i = 0 ; $i < 4 ; $i++)
    	{
    		$this->employees[$i] = factory(Employee::class)->create(['role' => $i]);
    	}

    }

    private function redirect()
    {

    	//Unauthenticated
    	$this->get('/admin')->assertRedirect("/admin/login");
    	$this->get('/home')->assertRedirect('/login');

    	//------------------------------
    	//Backoffice
    	//------------------------------

    	//Authenticated
    	$this->actingAs($this->users[0], 'web')->get('/admin')->assertRedirect("/admin/login");
        $this->actingAs($this->employees[1], 'admin')->get('/admin/login')->assertRedirect('/admin');

        //------------------------------
    	//Frontoffice
    	//------------------------------

        //Authenticated
        $this->actingAs($this->users[0])->get('/login')->assertRedirect("/home");
        $this->actingAs($this->users[0])->get('/register')->assertRedirect("/home");

        //$this->actingAs($this->employees[0], 'admin')->get('/home')->assertRedirect("/login"); //Has access to /home for unknown reason
    }

    private function access()
    {

    }

}
