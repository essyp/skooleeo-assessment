<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Mail;
use Session;
use GuzzleHttp\Exception\GuzzleException;
use DB;
use App\Models\Blog;
use App\Models\User;
use App\Models\Newsletter;
use App\Models\ViewHistory;
use App\Models\BlogCategory;

class HomeController extends Controller
{
    public function getHome() {
        $blogfeatured = Blog::where('status',1)->where('featured',1)->limit(4)->get();
        $category = BlogCategory::where('status',1)->get();
        $data = Blog::where('status',1)->orderBy('id', 'desc')->paginate(6);
        return view('front/index', compact('data','blogfeatured','category'));
    }

    public function genPasswordResetLink(){
        $id = Str::random(20);
        $validator = \Validator::make(['id'=>$id],['id'=>'unique:users,password_reset']);
        if($validator->fails()){
             return $this->genPasswordResetLink();
        }
        return $id;
    }
    
    public function forgotPassword(Request $request){
        $email = $request->email;
        $id = $this->genPasswordResetLink();
        $link = url('/')."/reset-password/".$id;
        $count = User::where('email', '=',$email)->count();
            if($count == 1) {
                $item = User::where('email',$email)->first();
                $item->password_reset = $id;
                $item->save();
                
                $name = $item->fname." ".$item->lname;
                $this->forgetPasswordMail("Reset Your Password",$email,$name,$link);
                $response = array(
                    "status" => "success",
                    "message" => "Password reset link sent to your email",
                );
                return Response::json($response);
            } else {
    
                $response = array(
                    "status" => "unsuccess",
                    "message" => "Email does not exist on our database",
                );
                return Response::json($response); //return status response as json
        }
    
    }
    public function forgetPasswordMail($subject,$email,$name,$link){
        $data = array(
                'link'=> $link,
                'name'=> $name,
                'email'=> $email,
                'subject'=> $subject
        );
        Mail::send('mails/password-reset', $data, function($message)
            use($email,$subject,$name,$link) {
            $message->from('fmogbana@gmail.com', 'Skooleeo Assessment');
            $message->to($email, $name)->subject($subject);
        });
    }

    public function getPasswordReset($id) {
        $user = User::where('password_reset',$id)->first();
        $email = $user->email;
    
         return view('front/reset-password', compact('user','id','email'));
    }

    public function resetPassword(Request $request){
        $id = $request->id;
        $email = $request->email;
        $password = $request->password;
        $count = User::where('password_reset', '=',$id)->count();
            if($count == 1) {
                $pass = User::where('password_reset',$id)->first();
                $pass->password = bcrypt($password);
                $pass->save();
               
                User::where('id',$pass->id)->update(['password_reset' => null]);
                
                $name = $pass->fname." ".$pass->lname;
                $this->resetPasswordMail("Password Reset Successful",$email,$name);
                $response = array(
                    "status" => "success",
                    "message" => "You have successfully changed your password. You can now login",
                );
                return Response::json($response);
            } else {
    
                $response = array(
                    "status" => "unsuccess",
                    "message" => "Error changing password. Please try again",
                );
                return Response::json($response); //return status response as json
        }
    
    }
    public function resetPasswordMail($subject,$email,$name){
        $data = array(
                'name'=> $name,
                'email'=> $email,
                'subject'=> $subject
        );
        Mail::send('mails/password-reset-success', $data, function($message)
            use($email,$subject,$name) {
            $message->from('fmogbana@gmail.com', 'Skooleeo Assessment');
            $message->to($email, $name)->subject($subject);
        });
    }

    public function newsletter(Request $request){
        $email = $request->email;
        $em = Newsletter::where('email', '=', $email)->first();
         if ($em === null) {
    
            $item = new Newsletter();
            $item->email = $email;
            $item->status = ACTIVE;
        
            if($item->save()){
        
                $response = array(
                    "status" => "success",
                    "message" => "Thanks for subscribing to our newsletters.",
                );
        
                return Response::json($response); //return status response as json
            } else {
                $response = array(
                    "status" => "unsuccessful",
                    "message" => "Error subscribing . Seems like you are already subscribed",
                );
                return Response::json($response); //return status response as json
            }
        } else{
            $response = array(
                "status" => "unsuccessful",
                "message" => "You are already subscribed. Thanks",
            );
            return Response::json($response); //return status response as json
        }
    }

    public function updateViews(Request $request) {
        $check = ViewHistory::where('blog_id',$request->blog_id)->where('user', \Request::ip())->count();
        if($check < 1){
           $data = Blog::where('id',$request->blog_id)->update(['views' => DB::raw('views+1')]);
        }

        $update = new ViewHistory();
        $update->blog_id = $request->blog_id;
        $update->user = \Request::ip();
        $update->save();
       
        return $data;
    }
}
