<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Repositories\UserRepository;

class PersonalInfoController extends Controller
{


    private $userRepository;
    private $amountPerPage = 1;

    /**
     * Create a new SiteController instance
     *
     * @param App\Repositories\UserRepository $siteRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth'); //Requires admin permission
        //TODO access levels
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $email = Auth::user()->email;
      $link = $this->userRepository->getWhere('email', $email, $this->amountPerPage);
      $user = $link[0];
      return view('user.myaccount.index', $user[0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showQrCode()
    {
      $id = Auth::user()->id_client;
      $user = $this->userRepository->getById($id);
      return view('user.myaccount.qrCode', $user->remember_token);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $id = Auth::user()->id_client;
      $user = $this->userRepository->getById($id);
      return view('user.myaccount.edit', $user);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Http\Requests\PersonalInfoRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonalInfoRequest $request, $id)
    {
        if(!is_numeric($id)) abort(404);
        $this->userRepository->update($id, $request->all());
        return redirect('admin/myaccount')->withOk("Votre profil a été mise à jour");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
