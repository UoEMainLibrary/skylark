<?php

namespace App\Http\Controllers\Collections\Lhsacasenotes;

use App\Http\Controllers\Controller;
use App\View\Composers\LhsacasenotesSidebarComposer;

class PageController extends Controller
{
    /**
     * Display the LHSA Case Notes homepage.
     *
     * Sidebar facets (Subject + Person) are injected by
     * {@see LhsacasenotesSidebarComposer} on `layouts.lhsacasenotes`,
     * so this action only needs to provide the page-specific data.
     */
    public function home()
    {
        return view('lhsacasenotes.home');
    }

    public function history()
    {
        return view('lhsacasenotes.pages.history');
    }

    public function people()
    {
        return view('lhsacasenotes.pages.people');
    }

    public function tuberculosis()
    {
        return view('lhsacasenotes.pages.tuberculosis');
    }

    public function achievements()
    {
        return view('lhsacasenotes.pages.achievements');
    }

    public function catalogues()
    {
        return view('lhsacasenotes.pages.catalogues');
    }
}
