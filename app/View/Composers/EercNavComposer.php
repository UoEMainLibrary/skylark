<?php

namespace App\View\Composers;

use Illuminate\View\View;

class EercNavComposer
{
    public function compose(View $view): void
    {
        $view->with('navItems', [
            ['label' => 'Home', 'url' => url('/eerc'), 'title' => 'Home'],
            ['label' => 'Browse the Collections', 'url' => url('/eerc/overview'), 'title' => 'Browse the Collections'],
            ['label' => 'About the Project', 'url' => url('/eerc/resp'), 'title' => 'About the RESP Archive Project'],
            ['label' => 'Searching and Using the Collection', 'url' => url('/eerc/using'), 'title' => 'Searching and Using the Collection'],
            ['label' => 'Exhibition Gallery', 'url' => url('/eerc/exhibition_gallery'), 'title' => 'Exhibition Gallery'],
            ['label' => 'Creative Engagement', 'url' => url('/eerc/creative-engagement'), 'title' => 'Creative Engagement and Research'],
            ['label' => 'Kids Only', 'url' => url('/eerc/kids_only'), 'title' => 'Kids Only'],
            ['label' => 'Project History', 'url' => url('/eerc/project-history'), 'title' => 'Project History'],
            ['label' => 'Contact', 'url' => url('/eerc/contact'), 'title' => 'Contact'],
            ['label' => 'Map', 'url' => url('/eerc/map'), 'title' => 'Interactive Map'],
        ]);
    }
}
