<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Mail;
use Session;

use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 5; // change to the max attemp you want.
    protected $decayMinutes = 5;

    private function throttle_seconds() {
        if(session()->has('throttle_seconds')) {
            $throttle_seconds = session('throttle_seconds');
            $throttle_current_time = session('throttle_current_time');
            $throttle_seconds = $throttle_current_time - time();
            if($throttle_seconds < 0) {
                $throttle_seconds = 0;
                $this->forget_throttle_seconds();
            }
        } else {
            session(['throttle_seconds' => ($this->decayMinutes* 60)]);
            session(['throttle_current_time' => (time() + ($this->decayMinutes* 60))]);
            $throttle_seconds = session('throttle_seconds');
        }
        return $throttle_seconds;
    }

    private function forget_throttle_seconds() {
        if(session()->has('throttle_seconds')) {
            session()->forget('throttle_seconds');
            session()->forget('throttle_current_time');
        }
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:200',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'tel' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            $response = array("status" => "fail", "message" => $validator->messages()->first());
            return Response::json($response);
           }
        if (User::where('email', '=', $request->email)->count() > 0) {
            $response = array(
                "status" => "Unsuccessful",
                "message" => "Email already exists. try registering with another email",
            );
            return Response::json($response); //return status response as json
        } else {

            if(!(User::where('ref_id','US-0001001')->first())){
                $ref_id='US-0001001';
            }
            else{
                $number=User::get()->last()->ref_id;
                $number=str_replace('US-',"",$number);
                $number=str_pad($number+1, 7, '0', STR_PAD_LEFT);
                $ref_id='US-'.$number;
                
            }
            
            $user = new User();
            $user->ref_id = $ref_id;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->tel = $request->tel;
            $user->email = $request->email;
            $user->status = ACTIVE;
            $user->password = bcrypt($request->password);

                if($user->save()){

                $response = array(
                    "status" => "success",
                    "message" => "Successful Registration. Thanks for registering with us",
                );

                return Response::json($response); //return status response as json
            } else {
                $response = array(
                    "status" => "Unsuccessfull",
                    "message" => "Error creating account. please try again",
                );
                return Response::json($response); //return status response as json
            }
        }
    }

    public function loginUser(Request $request) {
        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = $this->throttle_seconds();
            $this->fireLockoutEvent($request);
            // $this->sendLockoutResponse($request);
            $response = array("status" => "fail", "message" => "The given data was invalid.\nToo many login attempts. Please try again in {$seconds} seconds.");
            return Response::json($response);
        }
        $validator = Validator::make($request->all(), [
           'email' => 'required|string|max:200',
           'password' => 'required|string'
       ]);

       if ($validator->fails()) {
        $this->incrementLoginAttempts($request);
        $response = array("status" => "fail", "message" => $validator->messages()->first());
        return Response::json($response);
       }
        $email = $request->email;
        $password = $request->password;
        isset($request->remember_me) ? $remember = true : $remember = false;

        if (Auth::guard('user')->attempt(['email' => $email, 'password' => $password, 'status' => ACTIVE], $remember)) {
            // The user is active, not suspended, and exists.
            $this->clearLoginAttempts($request);
            $response = array("status" => "success", "message" => "Login Successful");
            return Response::json($response);
        }

        $this->incrementLoginAttempts($request);
        $this->forget_throttle_seconds();
        $response = array("status" => "fail", "message" => "Wrong email or password");
        return Response::json($response);
    }

    public function logoutUser(Request $request) {
        Auth::guard('user')->logout();
        session()->flush();
        return redirect('/login');
    }
}
