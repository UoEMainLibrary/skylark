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
            'events' => $slug === 'home' ? $this->upcoming()->limit(3)->get() : collect(),
        ]);
    }

    public function events(): View
    {
        abort_unless(config('stcecilias.museum_enabled'), 404);
        $page = StceciliasPage::query()->where('slug', 'whats-on')->where('is_visible', true)->firstOrFail();

        return view('stcecilias.museum.events', $this->shared() + ['page' => $page, 'events' => $this->upcoming()->paginate(12)]);
    }

    public function archive(): View
    {
        abort_unless(config('stcecilias.museum_enabled'), 404);
        $page = StceciliasPage::query()->where('slug', 'whats-on')->where('is_visible', true)->firstOrFail();
        $page->title = 'Past events';
        $page->intro = 'Explore past concerts, tours and activities at St Cecilia’s Hall.';
        $events = StceciliasEvent::query()->where('is_visible', true)
            ->where(fn (Builder $query) => $query->where('ends_at', '<', now())
                ->orWhere(fn (Builder $query) => $query->whereNull('ends_at')->where('starts_at', '<', now()->startOfDay())))
            ->orderByDesc('starts_at')->orderByDesc('id')->paginate(12);

        return view('stcecilias.museum.events', $this->shared() + ['page' => $page, 'events' => $events, 'archive' => true,
            'hasIcomArchive' => StceciliasPage::query()->where('slug', 'archive/icom-music-2026')->where('is_visible', true)->exists()]);
    }

    public function event(string $slug): View
    {
        abort_unless(config('stcecilias.museum_enabled'), 404);
        $event = StceciliasEvent::query()->where('slug', $slug)->where('is_visible', true)->firstOrFail();
        $page = StceciliasPage::query()->where('slug', 'whats-on')->where('is_visible', true)->firstOrFail();
        $page->title = $event->title;
        $page->intro = $event->intro;

        return view('stcecilias.museum.events', $this->shared() + [
            'page' => $page,
            'events' => collect([$event]),
            'detail' => true,
            'archive' => ($event->ends_at ?? $event->starts_at->endOfDay())->isPast(),
        ]);
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
            'navigation' => StceciliasPage::query()->where('is_visible', true)->whereIn('slug', ['home', 'planning-your-visit', 'whats-on', 'venue-hire', 'about-us'])->orderBy('navigation_order')->get(['slug', 'title']),
            'footerPages' => StceciliasPage::query()->where('is_visible', true)->whereIn('slug', ['contact-us', 'tours', 'learning', 'blog'])->orderBy('title')->get(['slug', 'title']),
            'collectionSearchUrl' => route('mimed.search.index', ['query' => config('stcecilias.collection_query')])];
    }
}
