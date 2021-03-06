<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Storage;
use Response;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Repositories\UserRepository;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use DateTime;

class UserController extends Controller
{
  private $userRepository;
  private $amountPerPage = 10;

  /**
  * Create a new UserController instance
  *
  * @param App\Repositories\UserRepository $UserRepository
  * @return void
  */
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
    $this->middleware('auth:admin', ['only' => ['showAdmin','editAdmin', 'updateAdmin', 'indexAdmin', 'destroyAdmin', 'unban']]);
    $this->middleware('auth:web' , ['except' => ['showAdmin','editAdmin', 'updateAdmin', 'indexAdmin', 'destroyAdmin', 'unban']]);
    $this->middleware('access:3', ['only' => ['editAdmin','updateAdmin','destroyAdmin', 'unban']]);
    $this->middleware('plan.valid', ['except' => ['editAdmin', 'updateAdmin', 'indexAdmin', 'destroyAdmin', 'unban']]);
  }


  /**
  * Display the personal information of the connected user.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $user = Auth::user();
    $plan = $user->plan()->first();

    if(!empty($plan))
    {
      $limitDate = $user->lastPayment()->limit_date;
      $dateFormat = new DateTime($limitDate);
      $limitDate = $dateFormat->format('d/m/Y');
    }

    return view('myaccount.index', compact('user', 'plan', 'limitDate'));
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
        $clients = $this->userRepository->getModel()->with('plan')->whereRaw('LOWER(email) LIKE ? OR LOWER(name) LIKE ? OR LOWER(surname) LIKE ? ORDER BY is_deleted', array($search,$search,$search))->take($this->amountPerPage)->get();
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
    return view('myaccount.qrcode', compact('user'));
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
  * Show the form for editing the specified resource. (admin)
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function editAdmin($id)
  {
    $user = $this->userRepository->getById($id);
    return view('admin.users.edit', compact('user'));
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
      Storage::delete('public/images/qrcode/'. Auth::user()->tokenQrCode .'.png');
      $qrcode_maker = 'cd '.storage_path().' && qrcode-maker ' . $request->email . ' ' . Auth::user()->tokenQrCode.' '. storage_path() . '/app/public/images/qrCode/';
      $a = shell_exec($qrcode_maker);
    }

    if(!is_numeric($id)) abort(404);
    if(Auth::user()->id_client != $id) abort(403);
    $this->userRepository->update($id, $request->all());
    return redirect('myaccount')->withOk("Votre profil a été mise à jour");
  }


  public function updateAdmin(UserRequest $request, $id)
  {
    if(!is_numeric($id)) abort(404);
    $this->userRepository->update($id, $request->all());
    return redirect('admin/user')->withOk("L'utilisateur " . $request->get('name') . " a été modifié");
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
    $id = Auth::user()->id_client;
    $this->userRepository->update($id, ["password"=>$request->password]);
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

  public function destroyAdmin($id)
  {
    if(!is_numeric($id)) abort(404);
    $user = $this->userRepository->getById($id)->name;
    $this->userRepository->destroy($id);
    return redirect('admin/user')->withOk("L'utilisateur " . $user . " a été banni.");
  }

  public function unban($id)
  {
    if(!is_numeric($id)) abort(404);
    $user = User::find($id);
    $user->is_deleted = 0;
    $user->save();
    return redirect('admin/user')->withOk("L'utilisateur " . $user->name . " a été gracié.");
  }
}
