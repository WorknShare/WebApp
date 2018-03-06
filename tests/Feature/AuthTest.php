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

    public function setUp() {
        parent::setUp();
        $this->createUsers();
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

    public function testRedirect()
    {

    	//Unauthenticated
    	$this->get('/admin')->assertRedirect("/admin/login");
    	$this->get('/home')->assertRedirect('/login');

    	//------------------------------
    	//Backoffice
    	//------------------------------

    	//Authenticated
        $this->be($this->users[0], 'web');
        $this->get('/admin/site')->assertRedirect("/admin/login");
    	$this->actingAs($this->users[0], 'web')->get('/admin')->assertRedirect("/admin/login");
    	Auth::logout();

    	$this->be($this->employees[1], 'admin');
        $this->get('/admin/login')->assertRedirect('/admin');
        Auth::logout();

        //------------------------------
    	//Frontoffice
    	//------------------------------

        //Authenticated
        $this->be($this->users[0], 'web');
        $this->get('/login')->assertRedirect("/home");
        $this->get('/register')->assertRedirect("/home");
        Auth::logout();

        $this->be($this->employees[1], 'admin');
        $this->get('/home')->assertRedirect('/login');
        Auth::logout();
    }

    public function testAccess()
    {
        //TODO
        $this->assertTrue(true);
    }

}
