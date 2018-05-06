<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function submitContactRequest(Request $request)
    {
        $ret = DB::transaction(function() use($request)
        {
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $message = $request->message;
            $reason = $request->reportReason;
            $subjectFromDB = DB::table("subject")->select('id')->where('name', '=', $subject)->first();
            if (!$subjectFromDB)
                return "error";
            $subjectid = $subjectFromDB->subjectid;
            
            DB::table("postreport")->insert([
                'message' => $message,
                'date' => now(),
                'userID' => Auth::user()->id,
                'subjectID' => $subjectid
            ]);
            return "success";
        });
        //this verifications instead of simply returning $ret ensures security in a way that if the transaction returns something other than the return values shown above
        //it does not send any DB server information to the user, thus not exposing something about and make it vulnerable to a certain attack
        //the user friendly message displaying is then handled by the view
        if ($ret == "success")
            return view('pages.contacts.contacts', ['resultMessage' => "success"]);
        else
            return view('pages.contacts.contacts', ['resultMessage' => "error"]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
