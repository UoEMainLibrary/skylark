<?php

namespace App\Http\Controllers\Collections\Stcecilias;

use App\Http\Controllers\Controller;
use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class MuseumController extends Controller
{
    public function page(string $slug = 'home'): View
    {
        abort_unless(config('stcecilias.museum_enabled'), 404);
        $page = StceciliasPage::query()->where('slug', $slug)->where('is_visible', true)->firstOrFail();

        return view('stcecilias.museum.page', $this->shared() + [
            'page' => $page,
            'events' => $this->upcoming()->limit(3)->get(),
        ]);
    }

    public function events(): View
    {
        abort_unless(config('stcecilias.museum_enabled'), 404);
        $page = StceciliasPage::query()->where('slug', 'whats-on')->where('is_visible', true)->firstOrFail();

        return view('stcecilias.museum.events', $this->shared() + ['page' => $page, 'events' => $this->upcoming()->paginate(12)]);
    }

    /** @return Builder<StceciliasEvent> */
    protected function upcoming(): Builder
    {
        return StceciliasEvent::query()->where('is_visible', true)->where(function (Builder $query): void {
            $query->where('ends_at', '>=', now())->orWhere(function (Builder $query): void {
                $query->whereNull('ends_at')->where('starts_at', '>=', now()->startOfDay());
            });
        })->orderBy('starts_at')->orderBy('id');
    }

    /** @return array<string, mixed> */
    protected function shared(): array
    {
        return ['visitorInformation' => StceciliasPage::query()->where('slug', 'planning-your-visit')->where('is_visible', true)->value('visitor_information') ?? [],
            'navigation' => StceciliasPage::query()->where('is_visible', true)->orderBy('navigation_order')->get(['slug', 'title']),
            'collectionSearchUrl' => route('mimed.search.index', ['query' => config('stcecilias.collection_query')])];
    }
}
