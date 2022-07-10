<?php

namespace App\Http\Controllers\Auth;

use App\Classes\GeniusMailer;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Generalsetting;
use App\SocialProvider;
use Socialite;
use Config;
use App\Notification;

class UserRegisterController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:user', ['except' => ['logout']]);
    }

    public function register(Request $request)
    {
      // Validate the form data

      $this->validate($request, [
        'email'   => 'required|email|unique:users',
        'password' => 'required|confirmed'
      ]);
        $gs = Generalsetting::findOrFail(1);
        $user = new User;
        $input = $request->all();
        $input['password'] = bcrypt($request['password']);
        $input['affilate_code'] = $request->name.$request->email;
        $input['affilate_code'] = md5($input['affilate_code']);
        $user->fill($input)->save();

        //Sending Email To Customer
        if($gs->is_smtp == 1)
        {
        $data = [
            'to' => $request->email,
            'type' => "new_registration",
            'cname' => $request->name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
        ];
        $mailer = new GeniusMailer();
        $mailer->sendAutoMail($data);
        }

        else
        {
       $to = $request->email;
       $subject = 'Welcome To'.$gs->title;
       $msg = "Hello ".$request->name.","."\n You have successfully registered to ".$gs->title."."."\n We wish you will have a wonderful experience using our service.";
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
       mail($to,$subject,$msg.$headers);
        }

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->save();
        Auth::guard('user')->login($user);
        return redirect()->route('/');
    }

    public function RegisterAjax(Request $request)
    {
      $users = User::where('email','=',$_REQUEST['personal_email'])->get();
      if(count($users) == 0) {
          if ($_REQUEST['personal_pass'] == $_REQUEST['personal_confirm']){
              $user = new User;
              $user->name = $_REQUEST['personal_name'];
              $user->email = $_REQUEST['personal_email'];
              $user->password = bcrypt($_REQUEST['personal_pass']);
              $token = md5(time().$_REQUEST['personal_name'].$_REQUEST['personal_email']);
              //$user->verification_link = $token;
              $user->affilate_code = md5($_REQUEST['personal_name'].$_REQUEST['personal_email']);
            //  $user->email_verified = 'Yes';
              $user->save();
              Auth::guard('user')->login($user);
              $response =array();
          return response()->json(['result' => $response,'status'=>true,'message'=>"Signup Successfully"],200);
          }else{
            $response =array();
            return response()->json(['result' => $response,'status'=>false,'message'=>"Confirm Password Doesn't Match."],200);
          }
      }else{
        $response =array();
        return response()->json(['result' => $response,'status'=>false,'message'=>"This Email Already Exist."],200);
      }

    }



}
