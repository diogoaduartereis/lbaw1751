<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Google_Client;
use GuzzleHttp;

class LoginController extends Controller {
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    public function username() {
        return 'username';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     * * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        if ($request->ajax()) {
            $uid = null;
            $id_token = iconv('ASCII', 'UTF-8', $request->password);
            $id = '914898849502-lcpd3q2madh2duv6banqs6ds5mue0fni';
            $client = new Google_Client(['client_id' => $id]);
            $client->setAuthConfig('secrets.json');
            $client->setDeveloperKey("AIzaSyBNhAuavpQaq9F5n9ZPa8-GZJHyGAvE4xE");
            $client->setHttpClient(new GuzzleHttp\Client(['verify' => false]));
            try {
                $payload = $client->verifyIdToken($id_token);
            } catch (\InvalidArgumentException $e) {
                return "args";
            }
            if ($payload) {
                $uid = $payload['sub'];
            } else {
                return "nay";
            }
            $user = null;
            try {
                $user = \App\User::where([
                            ['email', '=', $request->email],
                            ['auth_type', '=', 1]])->first();
            } catch (\Illuminate\Database\QueryException $e) {
                
            }
            if ($user == null) {
                $username = $request->username . rand();
                $ck = \App\User::where([
                            ['username', '=', $username]])->first();
                while ($ck != null) {
                    $username = $request->username . rand();
                    $ck = \App\User::where([
                                ['username', '=', username]])->first();
                }
                $user = new \App\User();
                $user->username = $username;
                $user->pass_token = $uid;
                $user->email = $request->email;
                $user->img_path = $request->picture;
                $user->auth_type = 1;
                $user->save();

                Auth::login($user);
                return 'valid';
            } else {
                if ($user->state != 'ACTIVE') {
                    return 'invalid';
                }
                if ($uid != $user->pass_token) {
                    return 'invalid';
                }
                $user->img_path = $request->picture;
                $user->save();
            }
            Auth::login($user);
            return 'valid';
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        //check for banned
        $user = \App\User::where('username', $request->username)->first();
        if ($user != null) 
        {
            if ($user->state == 'BANNED')
            {
                $message = "Your account has been banned ";
        
                $banReason = UserController::getBanReason($user->id);
                $message = $message . " because ". unserialize($banReason)->description;

                $timeRemaining = UserController::getUserBanRemainTime($user->id);
                if($timeRemaining == "permanent")
                    $message = $message . ". Permanent ban!";
                else
                    $message = $message . "! Time left: " . intval(ceil($timeRemaining)) . " days";
                
                return Redirect('/login')->withErrors($message);
            }
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string',
            'pass_token' => 'required|string',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'pass_token'), ['state' => 'ACTIVE']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

}
