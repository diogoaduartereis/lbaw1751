<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller {

    public static function getAvailableSubjects() {
        $subjectsArr = DB::table("subject")->select('name')->get();
        if (!$subjectsArr)
            return "error";
        else
            return $subjectsArr;
    }

    public function submitContactRequest(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;
        $reason = $request->reportReason;
        $error = false;
        if (empty($name))
            $error = true;

        if (empty($email))
            $error = true;

        if (empty($subject))
            $error = true;

        if (empty($message))
            $error = true;


        if ($error)
            return redirect()->back()->with('resultMessage', 'error');


        $ret = DB::transaction(function() use($name, $email, $subject, $message) {
                    $subjectFromDB = DB::table("subject")->select('subjectid')->where('name', '=', $subject)->first();
                    if (!$subjectFromDB)
                        return "error";
                    $subjectid = $subjectFromDB->subjectid;
                    $usrid = null;
                    if (Auth::check())
                        $usrid = Auth::user()->id;
                    DB::table("contact")->insert([
                        'message' => $message,
                        'date' => now(),
                        'userid' => $usrid,
                        'subjectid' => $subjectid
                    ]);
                    return "success";
                });
        //this verifications instead of simply returning $ret ensures security in a way that if the transaction returns something other than the return values shown above
        //it does not send any DB server information to the user, thus not exposing something about and make it vulnerable to a certain attack
        //the user friendly message displaying is then handled by the view
        if ($ret == "success")
            return redirect()->back()->with('resultMessage', 'success');
        else
            return redirect()->back()->with('resultMessage', 'error');
    }

    public function contacts() {
        return view('pages.contacts.contacts');
    }

    public function contactsList() {
        if (Auth::check() && Auth::user()->type == "ADMIN") {
            $contacts = DB::table('contact')
                            ->join('users', 'contact.userid', '=', 'users.id')
                            ->join('subject', 'contact.subjectid', '=', 'subject.subjectid')
                            ->select('contact.id', 'username', 'message', 'date', 'userid', 'subject.name as subject')
                            ->where('processed', '=', 'false')
                            ->orderBy('date', 'asc')->paginate(5);
            return view('pages.contacts.contactsList', ['contacts' => $contacts]);
        } else
            return redirect()->back();
    }

    public function markContactAsProcessed($contactId) {
        if (Auth::check() && Auth::user()->type == "ADMIN") {
            DB::table("contact")->where('id', $contactId)->update(array('processed' => true));
            return "";
        } else
            return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
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
