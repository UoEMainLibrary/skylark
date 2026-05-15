<?php

namespace App\Http\Controllers\Collections\Openbooks;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}
}
