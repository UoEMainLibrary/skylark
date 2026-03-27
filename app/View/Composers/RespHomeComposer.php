<?php

namespace App\View\Composers;

use App\Models\RespHomeContent;
use Illuminate\View\View;

class RespHomeComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'respHomeBodyHtml',
            RespHomeContent::query()
                ->where('slug', RespHomeContent::SLUG)
                ->value('body') ?? ''
        );
    }
}
