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
    public function getCurrentPoints()
    {
        return Auth::user()->points;
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
            DB::table('users')->where('id', $id)->update(['state' => 'INACTIVE']);
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

    public function banUserForm($id)
    {
        if(Auth::check() && Auth::user()->type == "ADMIN")
        {
            $user = DB::table('users')->select('id', 'username')->where('id', $id)->first();
            return view('pages.ban.banUser', ['user' => $user]);
        } 

        return redirect()->back();
    }

    public function banUserAction(Request $request, $id)
    {
        if(empty($id))
            return back()->withErrors(['msg' => "Id is empty"]);
        if (Auth::user()->type != "ADMIN")
            return redirect('/');
        if (Auth::user()->id == $id)
            return back()->withErrors(['msg' => "You can not ban yourself!"]);  
  
        try
        {
            if(trim($request->descriptionMessage) == "")
                return back()->withErrors(['msg' => "Description must be filled!"]);
            $endDate;
            $durationInDays;
            if($request->isPermanent == "Yes")
            {
                $endDate = null;
                $durationInDays = null;
            }
            else if(strtotime($request->endOfBanDate) > strtotime(date("Y/m/d")))
            {
                $endDate = $request->endOfBanDate;
                $durationInDays = (strtotime($endDate) - strtotime(date("Y/m/d"))) / 86400;
            }
            else
                return back()->withErrors(['msg' => "Ban must be either permanent or higher than 1 day!"]);

            DB::transaction(function () use($durationInDays, $request, $id, $endDate)
            {
                DB::table('baninfo')->insert(['duration' =>  $durationInDays, 'description' => $request->descriptionMessage, 
                    'ispermanent' => $request->isPermanent, 'enddate' => $endDate, 'userid' => $id, 'adminid' => Auth::user()->id]);
                DB::table('users')->where('id', $id)->update(['state' => 'BANNED']);     
            });             
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return back()->withErrors(['msg' => "Error inserting ban in database"]);
        }
  
        return redirect('users/' . $id); 
    }

    public function unbanUserAction(Request $request, $userId)
    {
        if(!Auth::check())
            return "error" ;
        if (Auth::user()->type != "ADMIN")
            return "error" ;
        if (Auth::user()->id == $userId)
            return "error" ;

        DB::table('users')->where('id', $userId)->update(['state' => 'ACTIVE']);     
               
        return "";
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::where('id', $id)->get();
        if($user == null || count($user) != 0)
        {
            $maxNumberPostsToShow = 8;
            $postsTitles = array();
            $userClosedPosts = DB::select('SELECT id, title, date FROM Post JOIN Question ON Post.id=Question.postID
                WHERE posterID=:posterID AND isClosed=true ORDER BY date DESC', ['posterID' => $id]);
            $userClosedPosts = array_slice($userClosedPosts, 0, $maxNumberPostsToShow);
            $userActivePosts = DB::select('SELECT id, title, date FROM Post JOIN Question ON Post.id=Question.postID
                WHERE posterID=:posterID AND isClosed=false ORDER BY date DESC', ['posterID' => $id]);
            $userActivePosts = array_slice($userActivePosts, 0, $maxNumberPostsToShow);

            return view('pages.View Profile.View Profile', ['user' => $user, 'userActivePosts' => $userActivePosts, 
                'userClosedPosts' => $userClosedPosts]);
        }
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
            return redirect()->back()->withErrors(['msg', 'No information can be empty, values must all be filled in.']);

        if($password != $password_confirmation)
            return redirect()->back()->withErrors(['msg', 'Password and password confirmation must be the same.']);

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
            return redirect()->back()->withErrors(['msg', 'Error editing profile']);
        }

        return redirect('');
    }

    public static function getNumberOfActiveQuestions()
    {
        $num = DB::table('post')
                        ->select('points')
                        ->where('posterid', '=', Auth::user()->id)
                        ->count();
        return $num;
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
