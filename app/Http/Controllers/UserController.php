<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use Input;
use Response;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Repositories\UserRepository;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
  private $userRepository;
  private $amountPerPage = 1;

  /**
  * Create a new UserController instance
  *
  * @param App\Repositories\UserRepository $UserRepository
  * @return void
  */
  public function __construct(UserRepository $userRepository)
  {
    //only or except
    $this->userRepository = $userRepository;
    $this->middleware('auth:admin', ['only' => ['showAdmin','editAdmin', 'updateAdmin', 'indexAdmin']]);
    $this->middleware('auth' , ['except' => ['showAdmin','editAdmin', 'updateAdmin', 'indexAdmin']]);

  }


  /**
  * Display the personal information of the connected user.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $user = Auth::user();
    return view('myaccount.index', compact('user'));
  }


  /**
  *  Display the personal information of a user. (admin)
  *
  * @param \App\Http\Requests\SearchRequest $request
  * @return \Illuminate\Http\Response
  */
  public function indexAdmin(SearchRequest $request)
  {

    if(!empty($request->search))
    {
        $search = '%'.strtolower($request->search).'%';
        $clients = $this->userRepository->getModel()->whereRaw('LOWER(email) LIKE ? OR LOWER(name) LIKE ? OR LOWER(surname) LIKE ?', array($search,$search,$search))->take($this->amountPerPage)->get();
        $links = '';
        return view('admin.users.index', compact('clients', 'links'));
    }
    else
    {
        $clients = $this->userRepository->getPaginate($this->amountPerPage);
        $links = $clients->render();
        return view('admin.users.index', compact('clients', 'links'));
    }

  }


  /**
  * Display the specified resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function showQrCode()
  {
    $user = Auth::user();
    return view('myaccount.qrCode', compact('user'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function edit()
  {
    $user = Auth::user();
    return view('myaccount.edit', compact('user'));
  }

  /**
  * Show the form for editing the password.
  *
  * @return \Illuminate\Http\Response
  */
  public function editPassword()
  {
    $user = Auth::user();
    return view('myaccount.editPassword', compact('user'));
  }

  /**
  * Show the form for editing the plan.
  *
  * @return \Illuminate\Http\Response
  */
  public function editPlan()
  {
    $user = Auth::user();
    return view('myaccount.editPlan', compact('user'));
  }


  /**
  * Show the form for editing the specified resource. (admin)
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function editAdmin($id)
  {
    $user = $this->userRepository->getById($id);
    return view('admin.user.edit', compact('user'));
  }



  /**
  * update the record in the database with the modified informations.
  *
  * @param  App\Http\Requests\UserRequest $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(UserRequest $request, $id)
  {
    if(strcmp($request->email, Auth::user()->email)){
      $qrcode_maker = 'rm -f ../storage/app/public/images/qrcode/'. Auth::user()->tokenQrCode .'.png && cd /bin && qrcode-maker ' . $request->email . ' ' . Auth::user()->tokenQrCode;
      $a = shell_exec($qrcode_maker);
    }

    if(!is_numeric($id) || Auth::user()->id_client != $id) abort(404);
    $this->userRepository->update($id, $request->all());
    return redirect('myaccount')->withOk("Votre profil a été mise à jour");
  }


  /**
  * update the record in the database with the modified informations.
  *
  * @param  App\Http\Requests\PasswordRequest $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function updatePwd(PasswordRequest $request)
  {

    if (!(Hash::check($request->get('oldPwd'), Auth::user()->password))) {
      return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
    }

    if(strcmp($request->get('oldPwd'), $request->get('password')) == 0){
      //Current password and new password are same
      return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
    }

    if(strcmp($request->get('password'), $request->get('confirmedPwd')) != 0){
      //Current password and new password are same
      return redirect()->back()->with("error","password are different.");
    }

    //Change Password
    $user = Auth::user();
    $user->password = $request->get('password');
    $user->save();

    return redirect('myaccount')->withOk("Votre mot de passe a été modifié avec succès !");
  }

  public function qrcodeAccess()
  {
    $token = Auth::user()->tokenQrCode;
    $content = storage_path() . '/app/public/images/qrCode/'. $token .'.png';
    $headers = array(
      "cache-control" => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0'
    );
    return response()->file($content,$headers);
  }

  public function QrCodeDownload()
  {
    $user = Auth::user();
    $content = storage_path() . '/app/public/images/qrCode/'. $user->tokenQrCode .'.png';
    return response()->download($content, 'qrcode.' . $user->name . '.png');
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
