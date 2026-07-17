<?php

namespace App\Http\Controllers\Collections\Speccoll;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Special Collections homepage — a hero image only, matching
     * the legacy Skylight speccoll `index.php`. `show_facets` is false so no
     * sidebar facets are hydrated.
     */
    public function home()
    {
        return view('speccoll.home');
    }
}
