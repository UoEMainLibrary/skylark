<?php

namespace App\Http\Controllers\Collections\CoimbraColls;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the Coimbra Colls Collection homepage.
     */
    public function home()
    {
        return view('coimbra-colls.home');
    }

    /**
     * Display the Coimbra Colls Virtual Exhibition page.
     */
    public function virtualExhibition()
    {
        return view('coimbra-colls.pages.virtual-exhibition');
    }
}
