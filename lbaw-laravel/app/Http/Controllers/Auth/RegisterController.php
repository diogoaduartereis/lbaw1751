<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Google_Client;
use GuzzleHttp;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    //'name' => 'required|string|max:255',
                    //'email' => 'required|string|email|max:255|unique:users',
                    'username' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        return User::create([
                    'email' => $data['email'],
                    'username' => $data['username'],
                    'pass_token' => bcrypt($data['password']),
                    'auth_type' => 0,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
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
                $user->img_path = $request->picture;
                $user->email = $request->email;
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
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

}
