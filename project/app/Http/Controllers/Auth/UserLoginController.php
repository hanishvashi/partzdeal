<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:user', ['except' => ['logout']]);
    }

 	public function showLoginForm()
    {

      return view('user.login');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if(isset($request->wish))
            {
                return redirect()->back();
            }
            else if(isset($request->package))
            {
                return redirect()->intended(route('user-package'));
            }
            else
            {
                return redirect()->intended(route('user-dashboard'));
            }
        }
        Session::flash('message',"f");
        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect('/');
    }

    public function loginAjax()
    {
      $user_email_address = $_REQUEST['user_email_address'];
      $user_password = $_REQUEST['user_password'];
        if (Auth::guard('user')->attempt(['email' => $user_email_address, 'password' => $user_password])) {
          $response =array();
          return response()->json(['result' => $response,'status'=>true,'message'=>"Login Successfully"],200);
        }else{
          $response =array();
          $response['ss'] = $user_email_address;
          $response['sss'] = $user_password;
          return response()->json(['result' => $response,'status'=>false,'message'=>"Invalid login details"],200);
        }
      }
}
