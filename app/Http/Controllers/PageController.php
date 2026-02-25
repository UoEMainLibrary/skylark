<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display the About page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the Feedback page
     */
    public function feedback()
    {
        return view('pages.feedback');
    }
}
