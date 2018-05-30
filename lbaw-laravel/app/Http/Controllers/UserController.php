<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use Hash;
use DB;
use Auth;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        
    }

    public function reports($id)
    {
        if(Auth::user()->type=='ADMIN') {
            $answers = \App\PostReport::select('postreport.postid','answer.questionid as questionid','reporterid', 'postreport.date as date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'postreport.reporterid', 'users.id')
                ->join('post','postreport.postid','post.id')
                ->join('answer','postreport.postid','answer.postid')
                ->where('post.posterid',$id)
                ->orderBy('date','DESC')->get();
            $questions = \App\PostReport::select('postreport.postid as postid','post.id as postid','reporterid', 'postreport.date as date', 'reason', 'username', 'type', 'email', 'state', 'img_path', 'users.points as userpoints','post.points as postpoints','post.content as content')
                ->join('users', 'id', 'reporterid')
                ->join('post','postreport.postid','post.id')
                ->join('question','postreport.postid','question.postid')
                ->where('post.posterid',$id)
                ->orderBy('date','DESC')->get();
            $ret = $answers->concat($questions);
            $ret->sortBy('date');
            return view('pages.reports.userreports', ['reports' => $ret],['id'=>$id]);
        }
        return redirect('404');
    }

    public function getSelfCurrentPoints() {
        $userPoints = Auth::user()->points;
        //for security purposes, do not return DB error information to the user possibly gibing 
        if ($userPoints)
            return $userPoints;
        else
            return "error";
    }

    /**
     * Login a user to the system.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $username = $request->input('form-username');
        $password = $request->input('form-password');

        if (empty($username) || empty($password))
            return redirect('login');
        try {
            $user = \App\User::where('username', $username)->get();

        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['msg' => "Username doesn't exist122112"]);
        }
        if ($user == null)
            return back()->withErrors(['msg' => "Username doesn't exist"]);
        else if ($user[0] == null)
            return back()->withErrors(['msg' => "Username doesn't exist"]);

        $user_id = $user[0]->id;
        $hashed_password = $user[0]->password;
        if (Hash::check($password, $hashed_password)) {
            session()->put('user_id', $user_id);
            return redirect('/');
        } else
            return back()->withErrors(['msg' => "Wrong password"]);

        return redirect('users/' + $id[0]->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $username = $request->input('form-username');
        $email = $request->input('form-email');
        $description = $request->input('form-about-yourself');
        $password = $request->input('form-password');
        $password_confirmation = $request->input('form-confirm-password');

        if (empty($username) || empty($email) || empty($description) || empty($password) || empty($password_confirmation))
            return redirect('register');

        if ($password != $password_confirmation)
            return redirect('register');

        try {
            DB::table('User')->insert(
                    ['username' => $username, 'pass_token' => password_hash($password, PASSWORD_BCRYPT), 'auth_type' => 0, 'email' => $email, 'description' => $description]);
        } catch (\Exception $e) {
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
    public function deleteUser($id) {
        if (empty($id))
            return back()->withErrors(['msg' => "Id is empty"]);
        if ($id != Auth::user()->id)
            return back()->withErrors(['msg' => "You only have permission to delete your own profile."]);
        try {
            DB::table('users')->where('id', $id)->update(['state' => 'INACTIVE']);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['msg' => "User doesn't exist"]);
        }

        Auth::logout();
        return redirect('');
    }

    public function logout() {
        if (!Auth::check())
            return redirect('/');

        Auth::logout();
        return redirect('');
    }

    public function banUserForm($id) {
        if (Auth::check() && Auth::user()->type == "ADMIN") {
            $user = DB::table('users')->select('id', 'username')->where('id', $id)->first();
            return view('pages.ban.index', ['user' => $user]);
        }

        return redirect()->back();
    }

    public function banUserAction(Request $request, $id) {
        if (empty($id))
            return back()->withErrors(['msg' => "Id is empty"]);
        if (Auth::user()->type != "ADMIN")
            return redirect('/');
        if (Auth::user()->id == $id)
            return back()->withErrors(['msg' => "You can not ban yourself!"]);

        try {
            if (trim($request->descriptionMessage) == "")
                return back()->withErrors(['msg' => "Description must be filled!"]);
            $endDate;
            $durationInDays;
            if ($request->isPermanent == "Yes") {
                $endDate = null;
                $durationInDays = null;
            } else if (strtotime($request->endOfBanDate) > strtotime(date("Y/m/d"))) {
                $endDate = $request->endOfBanDate;
                $durationInDays = (strtotime($endDate) - strtotime(date("Y/m/d"))) / 86400;
            } else
                return back()->withErrors(['msg' => "Ban must be either permanent or higher than 1 day!"]);

            DB::transaction(function () use($durationInDays, $request, $id, $endDate) {
                DB::table('baninfo')->insert(['duration' => $durationInDays, 'description' => $request->descriptionMessage,
                    'ispermanent' => $request->isPermanent, 'enddate' => $endDate, 'userid' => $id, 'adminid' => Auth::user()->id]);
                DB::table('users')->where('id', $id)->update(['state' => 'BANNED']);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['msg' => "Error inserting ban in database"]);
        }

        return redirect('users/' . $id);
    }

    public function unbanUserAction(Request $request, $userId) {
        if (!Auth::check())
            return "error";
        if (Auth::user()->type != "ADMIN")
            return "error";
        if (Auth::user()->id == $userId)
            return "error";

        DB::table('users')->where('id', $userId)->update(['state' => 'ACTIVE']);

        return $userId;
    }

   
    public static function getUserBanRemainTime($userId) 
    {
        $banInfo = DB::table('baninfo')->select('enddate', 'ispermanent')->where('userid', $userId)->first();
        if($banInfo->ispermanent == true)
            return "permanent";
        
        $timeRemaining = (strtotime($banInfo->enddate) - strtotime(date("Y/m/d"))) / 86400;
        return $timeRemaining;
    }


    public static function getBanReason($userId) 
    {
        $banReason = DB::table('baninfo')->select('description')->where('userid', $userId)->first();
        return serialize($banReason);
    }


    public function searchForUser(Request $request) 
    {
        if (Auth::check() && Auth::user()->type == "ADMIN") 
        {
            $username = $request->username;
            $query = DB::table('users');
            if (!$username)
                $users = $query->get();
            else
                $users = $query->whereRaw('to_tsvector(\'english\', username) @@ plainto_tsquery(\'english\', ?)', [$username])->get();

            return UserController::showAdminPage($users, $username);
        }
         else
            return back()->withErrors(['msg' => "You must be an admin"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $user = \App\User::where('id', $id)->get();
        if ($user == null || count($user) != 0) {
            $maxNumberPostsToShow = 8;
            $postsTitles = array();
            $userClosedPosts = DB::select('SELECT id, title, date FROM Post JOIN Question ON Post.id=Question.postID
                WHERE posterID=:posterID AND isvisible=true AND isClosed=true ORDER BY date DESC', ['posterID' => $id]);
            $userClosedPosts = array_slice($userClosedPosts, 0, $maxNumberPostsToShow);
            $userActivePosts = DB::select('SELECT id, title, date FROM Post JOIN Question ON Post.id=Question.postID
                WHERE posterID=:posterID AND isvisible=true AND isClosed=false ORDER BY date DESC', ['posterID' => $id]);
            $userActivePosts = array_slice($userActivePosts, 0, $maxNumberPostsToShow);

            return view('pages.ViewProfile.index', ['user' => $user, 'userActivePosts' => $userActivePosts,
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
    public function edit($id) {
        if ($id != Auth::user()->id && Auth::user()->type != "ADMIN")
            return back()->withErrors(['msg' => "You don´t have permission!"]);

        try {
            $user = DB::table('users')->select('*')->where('id', '=', $id)->get();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['msg' => "User doesn't exist!"]);
        }

        if (count($user) != 0)
            return view('pages.EditProfile.index', ['user' => $user[0]]);
        else
            return redirect('404');
    }

    /**
     * Edits a user's profile. Security verifications are performed so that to ensure that only the user has permission to change the profile.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function editProfile(Request $request) {
        if (!Auth::check())
            return redirect('/');

        $user_id = Auth::user()->id;
        $username = $request->input('form-username');
        $email = $request->input('form-email');
        $description = $request->input('form-about-yourself');
        $password = $request->input('form-password');
        $password_confirmation = $request->input('form-confirm-password');

        $imagePath = "0.png";
        $this->validate($request, ['fileToUpload' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        if($request->hasFile('fileToUpload')) 
        {
            $image = $request->file('fileToUpload');
            $name = $user_id . ".png";
            $destinationPath = public_path('/assets/img/users');
            $image->move($destinationPath, $name);
        }

        if (empty($username) || empty($email) || empty($description))
            return redirect()->back()->withErrors(['No information can be empty, values must all be filled in.']);
        if ($password != $password_confirmation)
            return redirect()->back()->withErrors(['Password and password confirmation must be the same.']);

        try {
            if (empty($password) && empty($password_confirmation)) {
                DB::table('users')->where('id', $user_id)->update(['username' => $username, 'email' => $email,
                    'description' => $description]);
            } else {
                DB::table('users')->where('id', $user_id)->update(['username' => $username,
                    'pass_token' => password_hash($password, PASSWORD_BCRYPT), 'email' => $email, 'description' => $description]);
            }

            if ($imagePath != "0.png")
                DB::table('users')->where('id', $user_id)->update(['img_path' => $imagePath]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Error editing profile']);
        }

        return redirect('users/' . $user_id);
    }

    public static function getNumberOfActiveQuestions() {
        $num = DB::table('post')
                ->select('points')
                ->where('posterid', '=', Auth::user()->id)
                ->count();
        return $num;
    }

    public static function getSelfXBestActiveQuestions($numOfQuestionsToRetrieve) {
        if (!Auth::check())
            return "error";

        //get some user active posts
        $userActivePosts = DB::select('SELECT id, title, date, points FROM Post JOIN Question ON Post.id=Question.postID
            WHERE posterID=:posterID AND isClosed=false ORDER BY points DESC LIMIT ' . $numOfQuestionsToRetrieve, ['posterID' => Auth::user()->id]);
        //for security purposes, do not return DB error information to the user possibly gibing 
        if (!$userActivePosts)
            return "error";
        else
            return $userActivePosts;
    }

    public static function showAdminPage($users, $username) 
    {
        $users = DB::table('users')->select('*')
                ->where('username', 'like', '%' . $username . '%')
                ->where('state', '!=', 'INACTIVE')
                ->paginate(20);

                
        return view('pages.admin.index', ['users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
