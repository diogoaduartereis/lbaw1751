<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public static function getAllFaqs()
    {
        $faqs = DB::table('faqentry')->select('question', 'answer')->get();
        //for security purposes, do not return DB error information to the user possibly gibing 
        if ($faqs)
            return $faqs;
        else
            return "error";
    }
}
