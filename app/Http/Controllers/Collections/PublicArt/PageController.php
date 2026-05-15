<?php

namespace App\Http\Controllers\Collections\PublicArt;

use App\Http\Controllers\Controller;
use App\Support\CollectionViewResolver;

class PageController extends Controller
{
    /**
     * Display the Public Art (Art on Campus) homepage.
     */
    public function home()
    {
        return view(CollectionViewResolver::publicArt('public-art.home'));
    }

    /**
     * Display the Public Art Paolozzi Mosaic Project page.
     */
    public function paolozzi()
    {
        return view(CollectionViewResolver::publicArt('public-art.pages.paolozzi'));
    }
}
