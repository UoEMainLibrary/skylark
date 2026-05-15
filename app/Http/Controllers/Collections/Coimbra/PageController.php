<?php

namespace App\Http\Controllers\Collections\Coimbra;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the Coimbra Collection homepage.
     */
    public function home()
    {
        return view('coimbra.home');
    }

    /**
     * Display the Coimbra Collection intro page.
     */
    public function intro()
    {
        return view('coimbra.pages.intro');
    }
}
