<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redirect;
use Hash;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $ret = (array)DB::select('SELECT * FROM Tag WHERE id=:id',['id' => $id]);
        if($ret!=null)
        {
            $str = '';
            foreach($ret as $val)
            {
                $str = $str.'Tag:'.$val->name."<br>";
            }
            return $str;
        }
        return 'Val:'.session('test');
    }

    public function test(Request $req){
        return $req->input('data');
    }

    //todo: begin add try

    public function postQuestionPage()
    {
        if(Auth::check())
        {
            return view('pages.Post question page.index');
        }
        else
            return view('pages.index');
    }

    public function postQuestion(Request $request)
    {
        if(Auth::check() == false)
            return redirect("/");

        $postID = DB::transaction(function() use($request)
        {
            $newPost = DB::table('post')->insertGetId([
                'posterid' => Auth::user()->id,
                'content'  => $request->input('content')
            ]);

            DB::table('question')->insert([
                'postid' => $newPost,
                'title'  => $request->input('title'),
            ]);

            $tagsString = trim($request->input('tags'));
            $tags = preg_split('/\s+/', $tagsString);
            for($i = 0; $i < count($tags); $i++)
            {
                $currTag = $tags[$i];
                $dbTag = DB::table('tag')->select('id')->where('name', $currTag)->first();
                if($dbTag == null)
                {
                    //insert new tag in database
                    $dbTagId = DB::table('tag')->insertGetId(['name' => $currTag]);
                }
                else
                {
                    $dbTagId = $dbTag->id;
                }
                
                DB::table('tagquestion')->insert([
                    'question_id' => $newPost,
                    'tag_id'  => $dbTagId,
                ]);
            }

            return $newPost;
        });

        if($postID != null)
            return redirect('questions/' . $postID);

    }

    public function showQuestionPage($id)
    {
        $questionElements = DB::table('post')->select('users.points as userPoints', 'users.*', 'post.id as post_id', 'post.posterid', 'post.content',
                                            'post.date','post.isvisible','post.points', 'question.*')
                                            ->join('users', DB::raw('post.posterid'), '=',DB::raw('users.id'))
                                            ->join('question', DB::raw('post.id'), '=', DB::raw('question.postid'))
                                            ->where(DB::raw('post.isvisible'), '=', TRUE)
                                            ->where(DB::raw('post.id'), '=', $id)
                                            ->get();

        $answersElements = DB::table('post')->select('users.*','post.id as post_id', 'post.posterid', 'post.content',
                                            'post.date as post_date','post.isvisible','post.points', 'answer.*')
                                            ->join('users', DB::raw('post.posterid'), '=',DB::raw('users.id'))
                                            ->join('answer', DB::raw('post.id'), '=', DB::raw('answer.postid'))
                                            ->where(DB::raw('post.isvisible'), '=', TRUE)
                                            ->where(DB::raw('answer.questionid'), '=', $id)
                                            ->orderBy('post_date', 'asc')
                                            ->get();

        $questionUserCounter = array(
            'posts' => DB::table('post')->where('posterid', '=', $questionElements[0]->id)->count('posterid'),
            'points' => DB::table('users')->where('id', '=', $questionElements[0]->id)->sum('points')
        );

        if(Auth::check())
            $postVotes = DB::table('postvote')->select('*')->where('posterid', '=', Auth::user()->id)->get();
        else
            $postVotes = null;

        $answerUserCounter = array();
        foreach($answersElements as $answerElements)
        {
            $row =  array(
                'posts' => DB::table('post')->where('posterid', '=', $answerElements->id)->count('posterid'),
                'points' => DB::table('users')->where('id', '=', $answerElements->id)->sum('points')
            );
            array_push($answerUserCounter, $row);
        }

        $questionUserPointsCounter = DB::table('post')->where('posterid', '=', $questionElements[0]->id)->count('posterid');

        return view('pages.View Question.index', ['questionElements' => $questionElements[0],
             'answersElements' => $answersElements, 'questionUserCounter' => $questionUserCounter,
             'answerUserCounter' => $answerUserCounter, 'postVotes' => $postVotes
             ]);
    }

    public function postAnswer($post_id, Request $request)
    {
        $user = Auth::user()->id;
        $postID = DB::transaction(function() use($request, $post_id)
        {
            $newPost = DB::table('post')->insertGetId([
                'posterid' => Auth::user()->id,
                'content'  => $request->input('content')
            ]);

            DB::table('answer')->insert([
                'postid' => $newPost,
                'questionid'  => $post_id,
                'iscorrect' => false
            ]);

            return $newPost;
        });

        if($post_id != null)
            return redirect('questions/' . $post_id);
    }

    public function closeQuestion($id)
    {
        if(Auth::check())
        {
            $logged_user_id = Auth::user()->id;
            $user = \App\User::where('id', $logged_user_id)->first();
            if($user == null)
                return redirect("/");
                
            $posterId = DB::select('SELECT posterID FROM Post WHERE id=:id', ['id' => $id])[0]->posterid;

            $validAccess = false;
            if($user->type == "ADMIN")
                $validAccess = true;
            else if($posterId == $logged_user_id)
                $validAccess = true;

            if($validAccess == false)
                return redirect("users/".$posterId);

            DB::table("question")->where('postid', $id)->update(array('isclosed'=>true));
            return redirect("users/".$posterId);
        }
    
        return redirect("/");
    }

    public function postVote(Request $request, $postId)
    {
        if(Auth::check())
        {
            $voteValue = $request->voteValue;
            $loggedUserId = Auth::user()->id;
            $postValueFromPreviousVote = DB::table("postvote")->select("value")->where('postid', $postId)
                ->where('posterid', $loggedUserId)->first();
               
            if(count($postValueFromPreviousVote) != 0)
            {
               
                if($postValueFromPreviousVote->value == $voteValue)
                {
                    DB::table("postvote")->where('postid', $postId)->where('posterid', $loggedUserId)->delete();
                    $postAtualPoints = DB::table("post")->select("points")->where('id', $postId)->first();
                    return $postAtualPoints->points;
                }
                    
                DB::table("postvote")->where('postid', $postId)->where('posterid', $loggedUserId)->update(['value' => $voteValue]);
                $postAtualPoints = DB::table("post")->select("points")->where('id', $postId)->first();
                return $postAtualPoints->points;
            }
            else
            {
                DB::table("postvote")->insert(['postid' => intval($postId), 'posterid' => intval($loggedUserId), 
                    'value' => intval($voteValue)]);
            }

            $postAtualPoints = DB::table("post")->select("points")->where('id', $postId)->first();
            return $postAtualPoints->points;
        }

        return "error";
    }

    public function delete($postId)
    {
        if(!Auth::check())
            return "error";

        $question = DB::table("question")->select("postid")->where('postid', $postId)->first();
        if($question != null)
            PostController::deleteQuestion($postId);

        $answer = DB::table("answer")->select("postid")->where('postid', $postId)->first();
        if($answer != null)
            PostController::deleteAnswer($postId);
    }

    public function deleteQuestion($postId)
    {
        DB::transaction(function() use($postId)
        {
            DB::table("post")->where('id', $postId)->update(array('isvisible'=>false));
            DB::table("postvote")->where('postid', $postId)->delete();
            
            $answersToQuestion = DB::table("answer")->select("postid")->where('questionid', $postId)->get();
            foreach($answersToQuestion as $answer)
                PostController::deleteAnswer($answer->postid);
        });
    }

    public function deleteAnswer($postId)
    {
        DB::transaction(function() use($postId)
        {
            DB::table("post")->where('id', $postId)->update(array('isvisible'=>false));
            DB::table("postvote")->where('postid', $postId)->delete();
        });
    }

    public function reportPost(Request $request, $postID)
    {
        $newReporterId = Auth::user()->id;
        $reason = $request->reportReason;
        return DB::transaction(function() use($postID, $newReporterId, $reason)
        {
            $reportAlreadyExistant = DB::table("postreport")->select('date')->where('postid', '=', $postID)->where('reporterid', '=', $newReporterId)->first();
            if ($reportAlreadyExistant)
               return "already reported";
            
            DB::table("postreport")->insert([
                'postid' => $postID,
                'reporterid' => $newReporterId,
                'reason' => $reason,
                'date'  => now()
            ]);
            return "success";
        });
    }

    //todo: end

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
