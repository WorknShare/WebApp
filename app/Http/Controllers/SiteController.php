<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\MealAffectRequest;
use App\Http\Requests\SiteRequest;
use App\Repositories\SiteRepository;

class SiteController extends Controller
{

    private $siteRepository;
    private $amountPerPage = 10;

    /**
     * Create a new SiteController instance
     *
     * @param App\Repositories\SiteRepository $siteRepository
     * @return void
     */
    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
        $this->middleware('auth:admin'); //Requires admin permission
        $this->middleware('password');
        $this->middleware('access:2', ['except' => ['index','show']]);
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
            $sites = $this->siteRepository->getWhere('name', $request->search, $this->amountPerPage);
            $links = '';
            return view('admin.sites.index', compact('sites', 'links'));
        }
        else
        {
            $sites = $this->siteRepository->getPaginate($this->amountPerPage);
            $links = $sites->render();
            return view('admin.sites.index', compact('sites', 'links'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\SiteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request)
    {
        $site = $this->siteRepository->store($request->all());
        return redirect('admin/site')->withOk("Le site " . $site->name . " a été créé.");
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
        $site = $this->siteRepository->getById($id);
        $schedules = $site->schedules()->orderBy('day', 'asc')->get();
        $rooms = $site->rooms()->join('room_types', 'rooms.id_room_type', '=', 'room_types.id_room_type')->select('rooms.*', 'room_types.name as room_type')->where([['rooms.is_deleted','=',0], ['room_types.is_deleted','=',0]])->get();
        $meals = $site->meals()->where('is_deleted','=',0)->get();
        return view('admin.sites.show', compact('site', 'schedules', 'rooms', 'meals'));
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
        $site = $this->siteRepository->getById($id);
        return view('admin.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\SiteRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);

        if(!$request->has('wifi')) { $request->merge(['wifi' => 0]); }
        if(!$request->has('drink')) { $request->merge(['drink' => 0]); }

        $this->siteRepository->update($id, $request->all());
        return redirect('admin/site/'.$id)->withOk("Le site " . $request->input('name') . " a été modifié.");
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
        $site = $this->siteRepository->getById($id);
        $name = $site->name;
        foreach($site->equipment() as $equipment) {
            $equipment->site()->dissociate();
            $equipment->save();
        }
        $this->siteRepository->destroy($id);
        return redirect('admin/site')->withOk("Le site " . $name . " a été supprimé.");
    }


    /**
     * Affects a meal to a site.
     *
     * @param  \App\Http\Requests\MealAffectRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function affectMeal(MealAffectRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);

        $site = $this->siteRepository->getById($id);
        $meal = \App\Meal::where('is_deleted','=',0)->find($request->meal);

        if(!is_null($meal))
            $site->meals()->attach($request->meal);
        else
            abort(400);

        return redirect('admin/site/'.$id)->withOk("Le repas " . $meal->name . " a été ajouté à ce site.");
    }

    /**
     * Remove a meal from a site.
     *
     * @param  \App\Http\Requests\MealAffectRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeMeal(MealAffectRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);

        $site = $this->siteRepository->getById($id);
        $meal = \App\Meal::where('is_deleted','=',0)->find($request->meal);

        if(!is_null($meal) && $site->meals->contains($request->meal))
            $site->meals()->detach($request->meal);
        else
            abort(400);

        return redirect('admin/site/'.$id)->withOk("Le repas " . $meal->name . " a été retiré de ce site.");
    }
}
