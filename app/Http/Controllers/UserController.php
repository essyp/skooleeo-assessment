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
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function getAccount() {
        $user = User::where('id',Auth::guard('user')->user()->id)->first();
        $blog = Blog::where('user_id',Auth::guard('user')->user()->id)->orderBy('id', 'desc')->limit(5)->get();
        $category = BlogCategory::where('status',1)->get();
        return view('user/account', compact('user','blog','category'));
    }

    public function getBlog() {
        $user = User::where('id',Auth::guard('user')->user()->id)->first();
        $blog = Blog::where('user_id',Auth::guard('user')->user()->id)->orderBy('id', 'desc')->paginate(5);
        $category = BlogCategory::where('status',1)->get();
        return view('user/blog', compact('user','blog','category'));
    }

    public function getChangePassword() {
        $user = User::where('id',Auth::guard('user')->user()->id)->first();
        return view('user/change-password', compact('user'));
    }

    public function getAccountUpdate() {
        $user = User::where('id',Auth::guard('user')->user()->id)->first();
        return view('user/account-update', compact('user'));
    }

    public function accountUpdate(Request $request){
        $image = $request->file('image');
        if(!is_null($image) && $image != ''){
            $imageName  = time() . '.' . $image->getClientOriginalExtension();
            $path = "images/users/";
            $image->move($path, $imageName);
        }
    
        $item = User::where('id', Auth::guard('user')->user()->id)->first();
        $item->fname = $request->fname;
        $item->lname = $request->lname;
        $item->tel = $request->tel;
        $item->address = $request->address;
        if(!is_null($image) && $image != ''){
        $item->avatar = $imageName;
        }
        if($item->save()){
            $response = array(
                "status" => "success",
                "message" => "Account information updated",
            );
            return Response::json($response);
        } else {
            $response = array(
                "status" => "unsuccessful",
                "message" => "Error updating account . Please try again",
            );
            return Response::json($response);
        }
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'curpass' => 'required|string','min:5', 'max:20',
            'newpass' => 'required|string','min:5','max:20',
            'newpass2' => 'required|string','min:5','max:20',
        ]);
        if ($validator->fails()){
            $response = array(
                "status" => "unsuccessful",
                "message" => $validator->messages()->first(),
            );
            return Response::json($response);
        }
        $old = $request->curpass;
        $newp = $request->newpass;
        $newp2 = $request->newpass2;
        $user = User::where('id',Auth::guard('user')->user()->id)->first();
    
        if($newp != $newp2){
            $response = array(
                'status' => 'error',
                'message' => 'New Password does not match',
            );
            return Response::json($response);
        } elseif(Hash::check($old, $user->password)){
            $user->password = bcrypt($newp);
            $user->save();
            $response = array(
                'status' => 'success',
                'message' => 'Password changed successfully',
            );
            return Response::json($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Current Password is incorrect',
            );
            return Response::json($response);
        }
    }

    public function createBlog(Request $request){
		
		$image = $request->file('image');
		if(!is_null($image) && $image != ''){
            $imageName  = time() . '.' . $image->getClientOriginalExtension();
            $path = "images/blog";
            $image->move($path, $imageName);
        }

        $item = new Blog();
        $item->user_id = Auth::guard('user')->user()->id;
		$item->title = $request->title;
        $item->cat_id = $request->cat_id;
        $item->keywords = $request->keywords;
        $item->status = ACTIVE;
        $item->description = $request->description;
        $item->slug = Str::slug($request->title).'-'.time();
        $item->video_id = $request->video_id;
        $item->is_video = $request->is_video;
		if(!is_null($image) && $image != ''){
            $item->image = $imageName;
        }

		if($item->save()){
            $response = array(
                "status" => "success",
                "message" => "Blog was created successfully",
            );

            return Response::json($response);
        } else {
            $response = array(
                "status" => "unsuccessful",
                "message" => "Error creating blog. Please try again",
            );
            return Response::json($response);
        }
    }

    public function updateBlog(Request $request){
		
		$image = $request->file('image');
        if(!is_null($image) && $image != ''){
            $imageName  = time() . '.' . $image->getClientOriginalExtension();
            $path = "images/blog";
            $image->move($path, $imageName);
        }

		$item = Blog::where('id',$request->id)->first();
		$item->title = $request->title;
        $item->cat_id = $request->cat_id;
        $item->keywords = $request->keywords;
        $item->description = $request->description;
        $item->video_id = $request->video_id;
        $item->is_video = $request->is_video;
        if(!is_null($image) && $image != ''){
            $item->image = $imageName;
        }
		if($item->save()){
            $response = array(
                "status" => "success",
                "message" => "blog was updated successfully",
            );
            return Response::json($response);
        } else {
            $response = array(
                "status" => "unsuccessful",
                "message" => "Error updating blog",
            );
            return Response::json($response);
        }
    }
    
    public function blogStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|array',
            'id.*' => 'required',
        ]);
        if ($validator->fails()){
            $response = array(
                "status" => "unsuccessful",
                "message" => $validator->messages()->first(),
                );
                return Response::json($response);
        }
        $id = $request->id;
       
		if($request->submit == "active") {
            foreach ($id as $idd) {
                Blog::where('id',$idd)->update(array('status' => ACTIVE));
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
            }   
        }elseif($request->submit == "inactive"){
            foreach ($id as $idd) {
                Blog::where('id',$idd)->update(array('status' => INACTIVE));
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
            }
        }elseif($request->submit == "featured"){
            foreach ($id as $idd) {
                Blog::where('id',$idd)->update(array('featured' => YES));
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
            }
        }elseif($request->submit == "unfeatured"){
            foreach ($id as $idd) {
                Blog::where('id',$idd)->update(array('featured' => NO));
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
            }
        }elseif($request->submit == "delete"){
            foreach ($id as $idd) {
                Blog::where('id',$idd)->delete();
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
            }
        }
		return Response::json($response);
    }
}
