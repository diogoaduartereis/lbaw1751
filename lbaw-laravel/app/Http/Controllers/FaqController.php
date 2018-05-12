<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Hash;
use DB;
use Auth;

class FaqController extends Controller {

    //returns a map that associates the faq category to an array of faqs that correpsond to that category
    public static function getAllFaqs() {
        $faqCats = DB::table('faqcategory')->select('name')->get();
        $faqMap = array();
        foreach ($faqCats as $faqCat) {
            $currFaq = DB::table('faqentry')->select('question', 'answer')
                            ->join('faqcategory', 'faqcategory.id', '=', 'faqentry.category')
                            ->where('faqcategory.name', '=', $faqCat->name)->get();
            if (!$currFaq)
                return "error";
            $faqMap[$faqCat->name] = $currFaq;
        }

        return $faqMap;
    }

}
