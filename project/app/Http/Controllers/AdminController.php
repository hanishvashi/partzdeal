<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AdminUserConversation;
use App\AdminUserMessage;
use App\Advertise;
use App\Classes\GeniusMailer;
use App\Counter;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use App\Order;
use App\Product;
use App\Review;
use App\Subscriber;
use App\User;
use App\UserNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Generalsetting;
use InvalidArgumentException;
use App\Comment;
use App\Stores;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    Public function getCurrentstoreid()
    {
      if (Session::has('CURRENT_STORE_ID')){
      $CURRENT_STORE_ID = session('CURRENT_STORE_ID');
      }else{
       $CURRENT_STORE_ID = 0;
      }
      return $CURRENT_STORE_ID;
    }

    public function index()
    {
        $users = User::all();
      //  $stores = Stores::all();
        $products = Product::where('store_id',$this->getCurrentstoreid())->get();
        $subs = Subscriber::all();
        $pending = Order::where('status','=','pending')->where('store_id',$this->getCurrentstoreid())->get();
        $processing = Order::where('status','=','processing')->where('store_id',$this->getCurrentstoreid())->get();
        $completed = Order::where('status','=','completed')->where('store_id',$this->getCurrentstoreid())->get();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $days = "";
        $sales = "";
        for($i = 0; $i < 30; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }

        $activation_notify = "";
        if (file_exists(public_path().'/rooted.txt')){
            $rooted = file_get_contents(public_path().'/rooted.txt');
            if ($rooted < date('Y-m-d', strtotime("+10 days"))){
                $activation_notify = "<i class='fa fa-warning fa-4x'></i><br>Please activate your system.<br> If you do not activate your system now, it will be inactive on ".$rooted."!!<br><a href='".url('/admin/activation')."' class='btn add-product_btn'>Activate Now</a>";
            }
        }



        return view('admin.index',compact('users','products','subs','pending','processing','completed','referrals','browsers','days','sales','activation_notify'));
    }

    public function StoreList()
    {
      $stores = Stores::all();
      return view('admin.store.index',compact('stores'));
    }

    public function createStore()
    {
      return view('admin.store.create');
    }

    public function storeSave(Request $request)
    {
        $storedb = new Stores;
        $input = $request->all();
        $storedb->fill($input)->save();
        $store_id = $storedb->id;
        $generalsetting = new Generalsetting;
        $gsdata['store_id'] = $store_id;
        $generalsetting->fill($gsdata)->save();
        Session::flash('success', 'New Store added successfully.');
        return redirect()->route('admin-stores');
    }

    public function editStore($id)
    {
        $storedetails = Stores::findOrFail($id);
        return view('admin.store.edit',compact('storedetails'));
    }

    public function updateStore(Request $request, $id)
    {
        $storedb = Stores::findOrFail($id);
        $input = $request->all();

        $storedb->update($input);
        Session::flash('success', 'Store updated successfully.');
        return redirect()->route('admin-stores');
    }

    public function storeChange(Request $request)
    {
      $input = $request->all();
      session()->put('CURRENT_STORE_ID', $input['current_store_id']);
    //  Session::set('CURRENT_STORE_ID', $input['current_store_id']);
      return redirect()->route('admin-dashboard');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function reviews()
    {
        $reviews = Review::orderBy('id','desc')->get();
        return view('admin.reviews.index',compact('reviews'));
    }
    public function reviewdelete($id)
    {
        $pick = Review::findOrFail($id);
        $pick->delete();
        return redirect()->route('admin-review-index')->with('success','Review Deleted Successfully.');
    }
    public function reviewshow($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.reviews.show',compact('review'));
    }

    public function comments()
    {
        $comments = Comment::orderBy('id','desc')->get();
        return view('admin.comment.index',compact('comments'));
    }
    public function commentdelete($id)
    {
    $comment = Comment::findOrFail($id);
    if($comment->replies->count() > 0)
    {
        foreach ($comment->replies as $reply) {
            if($reply->subreplies->count() > 0)
            {
                foreach ($reply->subreplies as $subreply) {
                    $subreply->delete();
                }
            }
            $reply->delete();
        }
    }
    $comment->delete();
    return redirect()->route('admin-comment-index')->with('success','Comment Deleted Successfully.');
    }
    public function commentshow($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comment.show',compact('comment'));
    }


    public function profileupdate(UpdateValidationRequest $request)
    {
        $input = $request->all();
        $admin = Auth::guard('admin')->user();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($admin->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/'.$admin->photo)) {
                        unlink(public_path().'/assets/images/'.$admin->photo);
                    }
                }
            $input['photo'] = $name;
            }

        $admin->update($input);
        Session::flash('success', 'Successfully updated your profile');
        return redirect()->back();
    }


    public function passwordreset()
    {
        return view('admin.reset-password');
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('unsuccess', 'Confirm password does not match.');
                    return redirect()->back();
                }
            }else{
                Session::flash('unsuccess', 'Current password Does not match.');
                return redirect()->back();
            }
        }
        $admin->update($input);
        Session::flash('success', 'Successfully updated your password');
        return redirect()->back();
    }
    public function messages()
    {
            $convs = AdminUserConversation::all();
            return view('admin.message.index',compact('convs'));
    }

    public function message($id)
    {
            $conv = AdminUserConversation::findOrfail($id);
            return view('admin.message.create',compact('conv'));
    }
    public function messagedelete($id)
    {
            $conv = AdminUserConversation::findOrfail($id);
            if($conv->messages->count() > 0)
            {
                foreach ($conv->messages as $key) {
                    $key->delete();
                }
            }
            if($conv->notifications->count() > 0)
            {
                foreach ($conv->notifications as $key) {
                    $key->delete();
                }
            }
            $conv->delete();
            return redirect()->back()->with('success','Conversation Deleted Successfully');
    }
    public function postmessage(Request $request)
    {
        $msg = new AdminUserMessage();
        $input = $request->all();
        $msg->fill($input)->save();
        $notification = new UserNotification;
        $notification->user_id= $msg->conversation->user->id;
        $notification->conversation1_id = $msg->conversation->id;
        $notification->save();
        Session::flash('success', 'Message Sent!');
        return redirect()->back();
    }
    public function usercontact(Request $request)
    {
        $data = 1;
        $admin = Auth::guard('admin')->user();
        $user = User::where('email','=',$request->to)->first();
        if(empty($user))
        {
            $data = 0;
            return response()->json($data);

        }
        $gs = Generalsetting::findOrFail(1);
        $subject = $request->subject;
        $to = $request->to;
        $from = $admin->email;
        $msg = "Email: ".$from."<br>Message: ".$request->message;
        if($gs->is_smtp == 1)
        {


            $datas = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];
            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($datas);
        }
        else
        {
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }

$conv = AdminUserConversation::where('user_id','=',$user->id)->where('subject','=',$subject)->first();
        if(isset($conv)){
            $msg = new AdminUserMessage();
            $msg->conversation_id = $conv->id;
            $msg->message = $request->message;
            $msg->save();
            return response()->json($data);
        }
        else{
            $message = new AdminUserConversation();
            $message->subject = $subject;
            $message->user_id= $user->id;
            $message->message = $request->message;
            $message->save();
                $notification = new UserNotification;
                $notification->user_id= $user->id;
                $notification->conversation1_id = $message->id;
                $notification->save();
            $msg = new AdminUserMessage();
            $msg->conversation_id = $message->id;
            $msg->message = $request->message;
            $msg->save();
            return response()->json($data);

        }
    }



    public function generate_bkup()
    {
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            $bkuplink = url($chk);
        }
        return view('admin.movetoserver',compact('bkuplink','chk'));
    }


    public function clear_bkup()
    {
        $destination  = public_path().'/install';
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        $handle = fopen('backup.txt','w+');
        fwrite($handle,"");
        fclose($handle);
        //return "No Backup File Generated.";
        return redirect()->back()->with('success','Backup file Deleted Successfully!');
    }


    public function activation()
    {
        return view('admin.activation');
    }

    public function activation_submit(Request $request)
    {
        //return config('services.genius.ocean');
        $purchase_code =  $request->pcode;
        $my_script =  'KingCommerce';
        $my_domain = url('/');

        $varUrl = str_replace (' ', '%20', config('services.genius.ocean').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

        if( ini_get('allow_url_fopen') ) {
            $contents = file_get_contents($varUrl);
        }else{
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $varUrl);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
        }

        $chk = json_decode($contents,true);

        if($chk['status'] != "success")
        {
            return redirect()->back()->with('unsuccess',$chk['message']);

        }else{
            $this->setUp($chk['p2'],$chk['lData']);

            if (file_exists(public_path().'/rooted.txt')){
                unlink(public_path().'/rooted.txt');
            }

//            $fpbt = fopen(public_path().'/activation.txt', 'w');
//            fwrite($fpbt, '');
//            fclose($fpbt);

            return redirect('admin/dashboard')->with('success','Congratulation!! Your System is successfully Activated.');
        }
        //return config('services.genius.ocean');
    }

    function setUp($mtFile,$goFileData){
        $fpa = fopen(public_path().$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }



    public function movescript(){
        ini_set('max_execution_time', 3000);

        $destination  = public_path().'/install';
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }

        $src = base_path().'/vendor/update';
        $this->recurse_copy($src,$destination);
        $files = public_path();
        $bkupname = 'KingCommerce-By-GeniusOcean-'.date('Y-m-d').'.zip';

        $zipper = new \Chumper\Zipper\Zipper;

        $zipper->make($bkupname)->add($files);

        $zipper->remove($bkupname);

        $zipper->close();

        $handle = fopen('backup.txt','w+');
        fwrite($handle,$bkupname);
        fclose($handle);

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        return response()->json(['status' => 'success','backupfile' => url($bkupname),'filename' => $bkupname],200);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }



}
