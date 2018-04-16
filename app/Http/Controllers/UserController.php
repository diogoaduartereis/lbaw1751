<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Hash;
use DB;
use Auth;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       
    }

    /**
     * Login a user to the system.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $username = $request->input('form-username');
        $password = $request->input('form-password');

        if(empty($username) || empty($password))
            return redirect('login');
        try
        {
            $user = \App\User::where('username', $username)->get();
            //$user = DB::table('"User"')->select('id, password')->where('username', '=', $username)->get();
            //$user = DB::select('SELECT id,password FROM "User" WHERE username=$1',[$username]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return back()->withErrors(['msg' => "Username doesn't exist122112"]);
        }
        if ($user == null)
            return back()->withErrors(['msg' => "Username doesn't exist"]);
        else if ($user[0] == null)
            return back()->withErrors(['msg' => "Username doesn't exist"]);
        
        $user_id = $user[0]->id;
        $hashed_password = $user[0]->password;
        if (Hash::check($password, $hashed_password))
        {
            session()->put('user_id', $user_id);
            return redirect('/');
        }
        else
            return back()->withErrors(['msg' => "Wrong password"]);

        return redirect('users/' + $id[0]->id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $username = $request->input('form-username');
        $email = $request->input('form-email');
        $description = $request->input('form-about-yourself');
        $password = $request->input('form-password');
        $password_confirmation = $request->input('form-confirm-password');

        if(empty($username) || empty($email) || empty($description) || empty($password) ||empty($password_confirmation))
            return redirect('register');

        if($password != $password_confirmation)
            return redirect('register');

        try
        {
            DB::table('User')->insert(
                ['username' => $username, 'pass_token' => password_hash($password, PASSWORD_BCRYPT), 'auth_type' => 0, 'email' => $email, 'description' => $description]);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['msg', 'Username already exists!']);
        }

        $id = DB::table('User')->select('id')->where('username', '=', $username)->get();
        session()->put('user_id', $id[0]->id);
        return redirect('');
    }

    /**
     * Delets a user (marks it as unactive in the database).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        if(empty($id))
            return back()->withErrors(['msg' => "Id is empty"]);
        if ($id != Auth::user()->id)
            return back()->withErrors(['msg' => "You only have permission to delete your own profile."]);
        try
        {
            DB::table('users')->where('id', $id)->update(['state' => 'UNACTIVE']);
            //$user = DB::table('"User"')->select('id, password')->where('username', '=', $username)->get();
            //$user = DB::select('SELECT id,password FROM "User" WHERE username=$1',[$username]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return back()->withErrors(['msg' => "User doesn't exist"]);
        }

        Auth::logout();
        return redirect('');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::check())
        {
            $logged_user_id = Auth::user()->id;
            $user = \App\User::where('id', $id)->get();
            if($user == null)
                return redirect('/');  
            if(count($user)!=0)
            {
                return view('pages.View Profile.View Profile', ['user' => $user]);
            }
            return redirect('/');
        }
        else //if is not a session defined
            return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = DB::table('users')->select('type')->where('id', '=', $id)->get();
        if($id != Auth::user()->id && count($type) != 0 && $type[0]->type != 'ADMIN')
            return back()->withErrors(['msg' => "You don´t have permission!"]);
        
        try
        {
            $user = DB::table('users')->select('*')->where('id', '=', $id)->get();
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return back()->withErrors(['msg' => "Username doesn't exist!"]);
        }

        if(count($user)!=0)
            return view('pages.Edit Profile.index', ['user' => $user[0]]);
        else
            return redirect('404');

    
    }

    /**
     * Edits a user's profile. Security verifications are performed so that to ensure that only the user has permission to change the profile.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function editProfile(Request $request)
    {
        if (!Auth::check())
            return redirect('/');
        
        $user_id = Auth::user()->id;
        $username = $request->input('form-username');
        $email = $request->input('form-email');
        $description = $request->input('form-about-yourself');
        $password = $request->input('form-password');
        $password_confirmation = $request->input('form-confirm-password');

        if(empty($username) || empty($email) || empty($description))
            return redirect()->back()->withErrors(['msg', 'No infomration can be empty, values must all be filled in.']);

        if($password != $password_confirmation)
            return redirect()->back()->withErrors(['msg', 'Password and password confimation must be the same.']);

        try
        {
            if(empty($password) && empty($password_confirmation))
            {
                DB::table('users')->where('id', $user_id)->update(['username' => $username, 'email' => $email,
                 'description' => $description]);
            }
            else
            {
                DB::table('users')->where('id', $user_id)->update(['username' => $username, 
                 'pass_token' => password_hash($password, PASSWORD_BCRYPT), 'email' => $email, 'description' => $description]);
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors(['msg', 'Erroe editing profile']);
        }

        return redirect('');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request;
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
