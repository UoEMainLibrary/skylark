<?php

namespace App\Http\Controllers\Collections\Iog;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function home()
    {
        return view('iog.home');
    }

    public function history()
    {
        return view('iog.pages.history');
    }
}
