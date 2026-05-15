<?php

namespace App\Http\Controllers\Collections\Art;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the Art Collection homepage.
     */
    public function home()
    {
        return view('art.home');
    }

    /**
     * Display the Art IIIF page.
     */
    public function iiif()
    {
        return view('art.pages.iiif');
    }

    /**
     * Display the Art Focus page.
     */
    public function focus()
    {
        return view('art.pages.focus');
    }

    /**
     * Display the Art Commissioning page.
     *
     * NB: misspelt "comissioning" preserved on purpose to keep the existing
     * route name + view filename stable; renaming it is part of the wider
     * naming-pass follow-up.
     */
    public function comissioning()
    {
        return view('art.pages.comissioning');
    }

    /**
     * Display the Art Loans page.
     */
    public function loans()
    {
        return view('art.pages.loans');
    }
}
