<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Employee;
use App\User;
use App\Site;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class SiteTest extends TestCase
{

    use RefreshDatabase;

    private $employees = [];
    private $user;

    public function setUp() {
        parent::setUp();
        for($i = 0 ; $i < 4 ; $i++)
    	{
    		$this->employees[$i] = factory(Employee::class)->create(['role' => $i]);
    	}
    	$this->user = factory(User::class)->create();
    }

    /**
     * Test site creation
     *
     * @return void
     */
    public function testSiteCreate()
    {
    	$this->be($this->employees[1], 'admin');

    	//Get list then form
        $this->get('admin/site')->assertStatus(200);
        $this->get('admin/site/create')->assertStatus(200);

        //Submit invalid form
        $this->post('/admin/site' , array('name' => 'Sitename'))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->post('/admin/site' , array('address' => '12 rue de l\'Avenue'))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->post('/admin/site' , array('name' => 'Sitename', 'wifi'=>1, 'drink'=>'1'))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->post('/admin/site' , array('name' => 'Sitename', 'fakeField'=>';DROP TABLE sites;'))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
		session()->forget('errors');

		//Submit valid form with extra field (SQL injection scenario)
		$this->post('/admin/site' , array('name' => 'Injection', 'address' => '12 rue de l\'Avenue', 'fakeField'=>';DROP TABLE sites;'))
				->assertRedirect('/admin/site')
				->assertSessionHas('ok', 'Le site Injection a été créé.');
		$this->assertDatabaseHas('sites', array('name' => 'Injection', 'address' => '12 rue de l\'Avenue'));
		session()->forget('ok');

		$this->get('/admin/site')->assertStatus(200)->assertSeeText('Injection');

		//Go back to creation form
		$this->get('/admin/site/create');

        //Submit valid form
        $this->post('/admin/site' , array('name' => 'Sitename', 'address' => '13 rue de l\'Avenue', 'wifi'=>1))
				->assertRedirect('/admin/site')
				->assertSessionHas('ok', "Le site Sitename a été créé.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'Sitename', 'address' => '13 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        //Uniqueness test
        $this->post('/admin/site' , array('name' => 'Sitename', 'address' => '14 rue de l\'Avenue', 'drink'=>1))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
        session()->forget('errors');
        $this->assertDatabaseMissing('sites', array('name' => 'Sitename', 'address' => '14 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        $this->post('/admin/site' , array('name' => 'Unique', 'address' => '12 rue de l\'Avenue', 'drink'=>1))
				->assertRedirect('/admin/site/create')
				->assertSessionHasErrors();
        session()->forget('errors');
        $this->assertDatabaseMissing('sites', array('name' => 'Unique', 'address' => '15 rue de l\'Avenue'));

       	$this->post('/admin/site' , array('name' => 'Unique', 'address' => '15 rue de l\'Avenue', 'drink'=>1))
				->assertRedirect('/admin/site')
				->assertSessionHas('ok', "Le site Unique a été créé.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'Unique', 'address' => '15 rue de l\'Avenue', 'wifi'=> 0, 'drink'=> 1));

        //Employee can see the site in the list
        $this->get('/admin/site')->assertStatus(200)->assertSeeText('Sitename');

        Auth::logout();

        //TODO access test
    }

    /**
     * Test site modify
     *
     * @return void
     */
    public function testSiteModify()
    {
    	$siteModify = factory(Site::class)->create();
    	$this->be($this->employees[1], 'admin');
        $this->assertTrue(true);

        Auth::logout();
        //TODO access test
    }

    /**
     * Test site schedule management
     *
     * @return void
     */
    public function testSiteSchedule()
    {
        $this->assertTrue(true);

        //TODO access test
    }

    /**
     * Test site deletion
     *
     * @return void
     */
    public function testSiteDelete()
    {
        $siteDelete = factory(Site::class)->create();
        $this->be($this->employees[1], 'admin');

        //Employee can see the site in the list
        $this->get('/admin/site')->assertStatus(200)->assertSeeText($siteDelete->name);

        //Send delete form
        $this->delete('/admin/site/'.$siteDelete->id_site)->assertStatus(302)->assertSessionHas('ok','Le site '.$siteDelete->name.' a été supprimé.');
        session()->forget('ok');
        $this->assertDatabaseMissing('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address));

        //Employee can't see the site in the list anymore
        $this->get('/admin/site')->assertStatus(200)->assertDontSeeText($siteDelete->name);

        Auth::logout();
        //TODO access test
    }

    /**
     * Test normal user access
     *
     * @return void
     */
    public function testSiteAccess()
    {
        $this->assertTrue(true);
    }

}
