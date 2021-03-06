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

        for($i = 4 ; $i < 8 ; $i++)
        {
            $this->employees[$i] = factory(Employee::class)->create(['role' => $i-4, 'changed_password' => false]);
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

        //Authenticated but didn't change password
        for ($i = 4 ; $i < 8 ; $i++) { 
            $this->be($this->employees[$i], 'admin');
            $this->get('/admin')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/employee')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/equipmenttype')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/plan')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/planadvantage')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/site')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/typeOfRooms')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/equipmenttype')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            $this->get('/admin/meal')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            //$this->get('/admin/user')->assertRedirect('/admin/employee/'. $this->employees[$i]->id_employee . '/editpasswordprompt');
            Auth::logout();
        }

        //------------------------------
    	//Frontoffice
    	//------------------------------

        //Unauthenticated
        $this->get('/myaccount')->assertRedirect('/login');

        //Authenticated
        $this->be($this->user, 'web');
        $this->get('/login')->assertRedirect("/myaccount");
        $this->get('/register')->assertRedirect("/myaccount");
        Auth::logout();

        $this->be($this->employees[1], 'admin');
        $this->get('/myaccount')->assertRedirect('/login');
        Auth::logout();
    }

}
