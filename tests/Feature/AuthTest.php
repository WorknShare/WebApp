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
	private $user;

    public function setUp() {
        parent::setUp();
        $this->createUsers();
    }

    private function createUsers()
    {
    	
    	$this->user = factory(User::class)->create();

    	for($i = 0 ; $i < 4 ; $i++)
    	{
    		$this->employees[$i] = factory(Employee::class)->create(['role' => $i]);
    	}

    }

    /**
     * Test the authentication redirects
     *
     * @return void
     */
    public function testRedirect()
    {


    	//------------------------------
    	//Backoffice
    	//------------------------------

    	//Unauthenticated
    	$this->get('/admin')->assertRedirect("/admin/login");

    	//Authenticated
        $this->be($this->user, 'web');
    	$this->get('/admin')->assertRedirect("/admin/login");
    	Auth::logout();

    	$this->be($this->employees[1], 'admin');
        $this->get('/admin/login')->assertRedirect('/admin');
        Auth::logout();

        //------------------------------
    	//Frontoffice
    	//------------------------------

        //Unauthenticated
        $this->get('/home')->assertRedirect('/login');

        //Authenticated
        $this->be($this->user, 'web');
        $this->get('/login')->assertRedirect("/home");
        $this->get('/register')->assertRedirect("/home");
        Auth::logout();

        $this->be($this->employees[1], 'admin');
        $this->get('/home')->assertRedirect('/login');
        Auth::logout();
    }

    /**
     * Tests the role-related access in the backoffice 
     *
     * @return void
     */
    public function testAccess()
    {
        //TODO
        $this->assertTrue(true);
    }

}
