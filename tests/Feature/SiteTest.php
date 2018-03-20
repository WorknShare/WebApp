<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Employee;
use App\User;
use App\Site;
use App\Schedule;
use App\RoomTypes;
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

        $this->be($this->user, 'web');

        //A normal user can't get list nor submit a form
        $this->get('admin/site')->assertRedirect('admin/login');
        $this->get('admin/site/create')->assertRedirect('admin/login');

        //Submit invalid form
        $this->post('/admin/site' , array('name' => 'SiteUser'))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

		//Submit valid form
        $this->post('/admin/site' , array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=>1))
				->assertRedirect('/admin/login')
				->assertSessionMissing('ok');
        session()->forget('ok');
        $this->assertDatabaseMissing('sites', array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        Auth::logout();

        //An unauthenticated user can't get list nor submit a form
        $this->get('admin/site')->assertRedirect('admin/login');
        $this->get('admin/site/create')->assertRedirect('admin/login');

        //Submit invalid form
        $this->post('/admin/site' , array('name' => 'SiteUser'))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

		//Submit valid form
        $this->post('/admin/site' , array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=>1))
				->assertRedirect('/admin/login')
				->assertSessionMissing('ok');
        session()->forget('ok');
        $this->assertDatabaseMissing('sites', array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        //Access test
        $this->be($this->employees[2], 'admin');

        $this->get('admin/site')->assertStatus(200)->assertSeeText('Ajouter un site');
        $this->post('/admin/site' , array('name' => 'Access', 'address' => '13 rue de l\'accès', 'wifi'=>1))
                ->assertRedirect('/admin/site')
                ->assertSessionHas('ok', "Le site Access a été créé.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'Access', 'address' => '13 rue de l\'accès', 'wifi'=> 1, 'drink'=> 0));

        Auth::logout();

        for ($i = 0; $i < 4 ; $i++) { 
            if($i == 1 || $i == 2) continue;

            $this->be($this->employees[$i], 'admin');
            $this->get('admin/site')->assertStatus(200)->assertDontSeeText('Ajouter un site');

            $this->get('admin/site/create')->assertStatus(403);
            $this->post('/admin/site' , array('name' => 'NoAccess', 'address' => '20 rue de l\'accès', 'wifi'=>1))
                ->assertStatus(403)
                ->assertSessionMissing('ok');
            session()->forget('ok');
            $this->assertDatabaseMissing('sites', array('name' => 'NoAccess', 'address' => '20 rue de l\'accès', 'wifi'=> 1, 'drink'=> 0));

            Auth::logout();
        }
    }

    /**
     * Test site show, mainly tests auth access
     *
     * @return void
     */
    public function testSiteShow()
    {
    	$siteShow = factory(Site::class)->create();
        factory(RoomTypes::class)->create(); //Avoid no room type message
    	$this->be($this->employees[1], 'admin');

    	//Employee can see site details
    	$this->get('admin/site/'. $siteShow->id_site)
    		->assertStatus(200)
    		->assertSeeText($siteShow->name)
    		->assertSeeText($siteShow->address)
            ->assertSeeText('Supprimer')
            ->assertSeeText('Modifier')
            ->assertSeeText('Ajouter un horaire')
            ->assertSeeText('Ajouter une salle');

		Auth::logout();

        $this->be($this->employees[2], 'admin');
        $this->get('admin/site/'. $siteShow->id_site)
            ->assertStatus(200)
            ->assertSeeText($siteShow->name)
            ->assertSeeText($siteShow->address)
            ->assertSeeText('Supprimer')
            ->assertSeeText('Modifier')
            ->assertSeeText('Ajouter un horaire')
            ->assertSeeText('Ajouter une salle');

        Auth::logout();

        $this->be($this->user, 'web');

        //Normal user can't see site details
        $this->get('admin/site/'. $siteShow->id_site)->assertRedirect('admin/login');

		Auth::logout();

		//Unauthenticated user can't see site details
		$this->get('admin/site/'. $siteShow->id_site)->assertRedirect('admin/login');

    	//Access test
        for ($i = 0; $i < 4 ; $i++) { 
            if($i == 1 || $i == 2) continue;

            $this->be($this->employees[$i], 'admin');
            $this->get('admin/site/'. $siteShow->id_site)
                        ->assertStatus(200)
                        ->assertSeeText($siteShow->name)
                        ->assertSeeText($siteShow->address)
                        ->assertDontSeeText('Supprimer')
                        ->assertDontSeeText('Modifier')
                        ->assertDontSeeText('Ajouter un horaire')
                        ->assertDontSeeText('Ajouter une salle');

            Auth::logout();
        }
    }

    /**
     * Test site modify
     *
     * @return void
     */
    public function testSiteModify()
    {
    	$siteModify = factory(Site::class)->create();
    	$siteModifyUnique = factory(Site::class)->create();
    	$this->be($this->employees[1], 'admin');

    	//Employee get edit form
        $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertStatus(200);

        //Submit with invalid method
        $this->post('/admin/site/'. $siteModify->id_site , array('name' => 'Sitename'))->assertStatus(405);

        //Submit invalid form
        $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'Sitename'))
				->assertRedirect('admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->put('/admin/site/'. $siteModify->id_site , array('address' => '12 rue de l\'Avenue'))
				->assertRedirect('admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'Sitename', 'wifi'=>1, 'drink'=>'1'))
				->assertRedirect('admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'Sitename', 'fakeField'=>';DROP TABLE sites;'))
				->assertRedirect('admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
		session()->forget('errors');

        //Submit valid form with extra field (SQL injection scenario)
        $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'InjectionModify', 'address' => '12 rue de la modification', 'fakeField'=>';DROP TABLE sites;'))
				->assertRedirect('/admin/site/'. $siteModify->id_site)
				->assertSessionHas('ok', 'Le site InjectionModify a été modifié.');
		$this->assertDatabaseHas('sites', array('name' => 'InjectionModify', 'address' => '12 rue de la modification'));
		session()->forget('ok');

		$this->get('/admin/site/'. $siteModify->id_site)->assertStatus(200)->assertSeeText('InjectionModify');
		$this->get('/admin/site')->assertStatus(200)->assertSeeText('InjectionModify');

        //Submit valid form
        $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SitenameModify', 'address' => '13 rue de la modification', 'wifi'=>1))
				->assertRedirect('/admin/site/'. $siteModify->id_site)
				->assertSessionHas('ok', "Le site SitenameModify a été modifié.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'SitenameModify', 'address' => '13 rue de la modification', 'wifi'=> 1, 'drink'=> 0));

        //Employee can see the modification in the list and on the show page
        $this->get('/admin/site')->assertStatus(200)->assertSeeText('SitenameModify');
        $this->get('/admin/site/'. $siteModify->id_site)->assertStatus(200)->assertSeeText('SitenameModify');

        //Uniqueness test
        $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertStatus(200);
        $this->put('/admin/site/'. $siteModify->id_site , array('name' => $siteModifyUnique->name, 'address' => $siteModifyUnique->address, 'drink'=>1))
				->assertRedirect('/admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
        session()->forget('errors');
        $this->assertDatabaseMissing('sites', array('id_site' => $siteModify->id_site, 'name' => $siteModifyUnique->name, 'address' => $siteModifyUnique->address, 'wifi'=> 1, 'drink'=> 0));

        $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'UniqueModify', 'address' => $siteModifyUnique->address, 'drink'=>1))
				->assertRedirect('/admin/site/'. $siteModify->id_site .'/edit')
				->assertSessionHasErrors();
        session()->forget('errors');
        $this->assertDatabaseMissing('sites', array('name' => 'UniqueModify', 'address' => $siteModifyUnique->address));

       	$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'UniqueModify', 'address' => '15 rue de l\'Avenue', 'drink'=>1))
				->assertRedirect('/admin/site/'. $siteModify->id_site)
				->assertSessionHas('ok', "Le site UniqueModify a été modifié.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'UniqueModify', 'address' => '15 rue de l\'Avenue', 'wifi'=> 0, 'drink'=> 1));

        Auth::logout();
        $this->be($this->user, 'web');

        //A normal user can't get the edit form
        $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertRedirect('admin/login');

        //Submit invalid form
		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SiteUser'))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

        //Submit valid form
		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=>1))
				->assertRedirect('/admin/login')
				->assertSessionMissing('ok');
        session()->forget('ok');
        $this->assertDatabaseMissing('sites', array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        Auth::logout();

        //An unauthenticated user can't get the edit form
        $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertRedirect('admin/login');

        //Submit invalid form
		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SiteUser'))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

        //Submit valid form
		$this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=>1))
				->assertRedirect('/admin/login')
				->assertSessionMissing('ok');
        session()->forget('ok');
        $this->assertDatabaseMissing('sites', array('name' => 'SiteUser', 'address' => '20 rue de l\'Avenue', 'wifi'=> 1, 'drink'=> 0));

        //Access test
        $this->be($this->employees[2], 'admin');

        $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertStatus(200);
        $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SitenameModifyAccess', 'address' => '13 rue de la modification', 'wifi'=>1))
                ->assertRedirect('/admin/site/'. $siteModify->id_site)
                ->assertSessionHas('ok', "Le site SitenameModifyAccess a été modifié.");
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => 'SitenameModifyAccess', 'address' => '13 rue de la modification', 'wifi'=> 1, 'drink'=> 0));

        Auth::logout();

        for ($i = 0; $i < 4 ; $i++) { 
            if($i == 1 || $i == 2) continue;

            $this->be($this->employees[$i], 'admin');

            $this->get('admin/site/'. $siteModify->id_site .'/edit')->assertStatus(403);
            $this->put('/admin/site/'. $siteModify->id_site , array('name' => 'SitenameModifyNoAccess', 'address' => '13 rue de la modification', 'wifi'=>1))
                ->assertStatus(403)
                ->assertSessionMissing('ok');
            $this->assertDatabaseMissing('sites', array('name' => 'SitenameModifyNoAccess', 'address' => '13 rue de la modification', 'wifi'=> 1, 'drink'=> 0));


            Auth::logout();
        }
    }

    /**
     * Test site schedule management
     *
     * @return void
     */
    public function testSiteSchedule()
    {
    	$siteSchedule = factory(Site::class)->create();
        $this->be($this->employees[1], 'admin');

        $this->get('admin/site/'. $siteSchedule->id_site)->assertStatus(200);

        //Employee can create schedule
        //Submit invalid form
        $this->post('/schedule' , array('id_site' => $siteSchedule->id_site))
				->assertRedirect('/admin/site/'. $siteSchedule->id_site)
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=>1, 'hour_opening'=> 'date', 'hour_closing' => '17:00'))
				->assertRedirect('/admin/site/'. $siteSchedule->id_site)
				->assertSessionHasErrors();
		session()->forget('errors');

		$this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=>1, 'hour_opening'=> '18:00', 'hour_closing' => '17:00'))
				->assertRedirect('/admin/site/'. $siteSchedule->id_site)
				->assertSessionHasErrors();
		session()->forget('errors');

		for ($i = 0 ; $i < 7 ; $i++)
		{ 
		
			//Submit valid form
			$this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=> $i, 'hour_opening'=> '0'.$i.':00', 'hour_closing' => ($i+10).':00'))
				->assertRedirect('/admin/site/'. $siteSchedule->id_site)
				->assertSessionHas('ok', 'L\'horaire a été créé.');
			session()->forget('ok');
			$this->assertDatabaseHas('site_schedules', array('day' => $i, 'hour_opening'=> '0'.$i.':00', 'hour_closing' => '0'.($i+10).':00'));

        	//See schedule in list
        	$this->get('admin/site/'. $siteSchedule->id_site)->assertSeeText($i.':00')->assertSeeText(($i+10).':00');

        	//Delete the schedule
    		$this->delete('schedule/'.($i+1))->assertRedirect('admin/site/'. $siteSchedule->id_site)->assertSessionHas('ok','L\'horaire a été supprimé.');
    		session()->forget('ok');
    		$this->assertDatabaseMissing('site_schedules', array('day' => $i, 'hour_opening'=> '0'.$i.':00', 'hour_closing' => '0'.($i+10).':00'));

        	//Don't see the schedule anymore in the list
    		$this->get('admin/site/'. $siteSchedule->id_site)->assertDontSeeText($i.':00')->assertDontSeeText(($i+10).':00');

		}

        Auth::logout();
        $this->be($this->user, 'web');

        //Normal user can't create nor destroy a schedule
        //Submit invalid form
        $this->post('/schedule' , array('id_site' => $siteSchedule->id_site))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

		//Submit valid form
		$this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=> 2, 'hour_opening'=> '02:00', 'hour_closing' => '10:00'))
			->assertRedirect('/admin/login')
			->assertSessionMissing('ok');
		session()->forget('ok');
		$this->assertDatabaseMissing('site_schedules', array('day' => 2, 'hour_opening'=> '02:00', 'hour_closing' => '10:00'));

		$schedule = factory(Schedule::class)->create(['id_site' => $siteSchedule->id_site]);
		$this->delete('schedule/'. $schedule->id_schedule)->assertRedirect('admin/login')->assertSessionMissing('ok');

        Auth::logout();

        //Unauthenticated user can't create nor destroy a schedule
        //Submit invalid form
        $this->post('/schedule' , array('id_site' => $siteSchedule->id_site))
				->assertRedirect('/admin/login')
				->assertSessionMissing('errors');

		//Submit valid form
		$this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=> 2, 'hour_opening'=> '02:00', 'hour_closing' => '10:00'))
			->assertRedirect('/admin/login')
			->assertSessionMissing('ok');
		session()->forget('ok');
		$this->assertDatabaseMissing('site_schedules', array('day' => 2, 'hour_opening'=> '02:00', 'hour_closing' => '10:00'));

		$schedule = factory(Schedule::class)->create(['id_site' => $siteSchedule->id_site]);
		$this->delete('schedule/'. $schedule->id_schedule)->assertRedirect('admin/login')->assertSessionMissing('ok');

        //Access test
        $this->be($this->employees[2], 'admin');
        $this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=> 3, 'hour_opening'=> '22:00', 'hour_closing' => '23:00'))
            ->assertRedirect('/admin/site/'. $siteSchedule->id_site)
            ->assertSessionHas('ok', 'L\'horaire a été créé.');
        session()->forget('ok');
        $this->assertDatabaseHas('site_schedules', array('day' => 3, 'hour_opening'=> '22:00', 'hour_closing' => '23:00'));

        Auth::logout();

        for ($i = 0; $i < 4 ; $i++) { 
            if($i == 1 || $i == 2) continue;

            $this->be($this->employees[$i], 'admin');

            $this->post('/schedule' , array('id_site' => $siteSchedule->id_site, 'day'=> 3, 'hour_opening'=> '22:10', 'hour_closing' => '23:10'))
                ->assertStatus(403)
                ->assertSessionMissing('ok');
            $this->assertDatabaseMissing('site_schedules', array('day' => 3, 'hour_opening'=> '22:10', 'hour_closing' => '23:10'));


            Auth::logout();
        }
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
        $this->get('/admin/site')->assertStatus(200)->assertSeeText(e($siteDelete->name));

        //Send delete form
        $this->delete('/admin/site/'.$siteDelete->id_site)->assertRedirect('admin/site')->assertSessionHas('ok','Le site '.$siteDelete->name.' a été supprimé.');
        session()->forget('ok');
        $this->assertDatabaseHas('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address, 'is_deleted' => 1));

        //Employee can't see the site in the list anymore
        $this->get('/admin/site')->assertStatus(200)->assertDontSeeText(e($siteDelete->name));

        Auth::logout();
        $siteDelete = factory(Site::class)->create();

        $this->be($this->user, 'web');

        //A normal user can't delete a site
        $this->delete('/admin/site/'.$siteDelete->id_site)->assertRedirect('admin/login')->assertSessionMissing('ok');
        $this->assertDatabaseHas('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address, 'is_deleted' => 0));

        Auth::logout();

        //An unauthenticated user can't delete a site
        $this->delete('/admin/site/'.$siteDelete->id_site)->assertRedirect('admin/login')->assertSessionMissing('ok');
        $this->assertDatabaseHas('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address, 'is_deleted' => 0));
       
        //Access test
        $this->be($this->employees[2], 'admin');

        $this->delete('/admin/site/'.$siteDelete->id_site)->assertRedirect('admin/site')->assertSessionHas('ok','Le site '.$siteDelete->name.' a été supprimé.');
        $this->assertDatabaseHas('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address, 'is_deleted' => 1));

        Auth::logout();

        $siteDelete->is_deleted = 0;
        $siteDelete->save();

        for ($i = 0; $i < 4 ; $i++) { 
            if($i == 1 || $i == 2) continue;

            $this->be($this->employees[$i], 'admin');

            $this->delete('/admin/site/'.$siteDelete->id_site)->assertStatus(403)->assertSessionMissing('ok');
            $this->assertDatabaseHas('sites', array('name' => $siteDelete->name, 'address' => $siteDelete->address, 'is_deleted' => 0));

            Auth::logout();
        }

    }

}
