<?php

namespace App\Http\Controllers\Collections\Pointsofarrival;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pointsofarrival.home');
    }

    public function content(string $page): View
    {
        $allowed = config('skylight.content_pages', []);

        if (! in_array($page, $allowed, true)) {
            abort(404);
        }

        return view("pointsofarrival.pages.{$page}");
    }
}
