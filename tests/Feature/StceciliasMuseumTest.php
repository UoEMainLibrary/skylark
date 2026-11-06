<?php

use App\Filament\Resources\StceciliasEvents\Pages\ManageStceciliasEvents;
use App\Filament\Resources\StceciliasPages\Pages\ManageStceciliasPages;
use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use App\Models\User;
use Database\Seeders\StceciliasMuseumSeeder;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['stcecilias.museum_enabled' => true]);
    Http::preventStrayRequests();
});

it('renders the four populated milestone pages without a catalogue request', function (string $path, string $text): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $this->get($path)->assertSuccessful()->assertSee($text)->assertDontSee('<form', false);
    Http::assertNothingSent();
})->with([
    ['/stcecilias', 'A living museum of music'],
    ['/stcecilias/planning-your-visit', 'Wheelchairs and lift'],
    ['/stcecilias/venue-hire', '£960'],
    ['/stcecilias/whats-on', 'What’s on'],
]);

it('links collection exploration to the location query on MIMEd', function (): void {
    StceciliasPage::factory()->create(['slug' => 'home']);
    $url = route('mimed.search.index', ['query' => config('stcecilias.collection_query')]);
    $this->get('/stcecilias')->assertSuccessful()->assertSee(e($url), false)->assertDontSee('Refine Results');
});

it('hides unpublished pages and hides preview routes when the switch is off', function (): void {
    StceciliasPage::factory()->create(['slug' => 'venue-hire', 'is_visible' => false]);
    $this->get('/stcecilias/venue-hire')->assertNotFound();
    config(['stcecilias.museum_enabled' => false]);
    $this->get('/stcecilias/planning-your-visit')->assertNotFound();
});

it('lists upcoming and ongoing events in order while excluding hidden and finished events', function (): void {
    $this->travelTo(now()->setDate(2026, 11, 3)->setTime(12, 0));
    StceciliasPage::factory()->create(['slug' => 'whats-on']);
    StceciliasEvent::factory()->create(['title' => 'Ongoing trail', 'starts_at' => now()->subDay(), 'ends_at' => now()->addDay()]);
    StceciliasEvent::factory()->create(['title' => 'Future concert', 'starts_at' => now()->addDay(), 'ends_at' => now()->addDays(2)]);
    StceciliasEvent::factory()->create(['title' => 'Finished concert', 'starts_at' => now()->subDays(2), 'ends_at' => now()->subDay()]);
    StceciliasEvent::factory()->create(['title' => 'Hidden concert', 'is_visible' => false]);
    $this->get('/stcecilias/whats-on')->assertSuccessful()->assertSeeInOrder(['Ongoing trail', 'Future concert'])->assertDontSee('Finished concert')->assertDontSee('Hidden concert');
});

it('paginates events and provides an honest empty state', function (): void {
    StceciliasPage::factory()->create(['slug' => 'whats-on']);
    $this->get('/stcecilias/whats-on')->assertSee('There are no upcoming events');
    StceciliasEvent::factory()->count(13)->create();
    $this->get('/stcecilias/whats-on')->assertViewHas('events', fn ($events) => $events->count() === 12 && $events->total() === 13);
    $this->get('/stcecilias/whats-on?page=2')->assertViewHas('events', fn ($events) => $events->count() === 1);
});

it('sanitizes rich content and escapes page titles', function (): void {
    StceciliasPage::factory()->create(['slug' => 'venue-hire', 'title' => '<script>titleAttack()</script>', 'body' => '<p>Safe copy</p><script>bodyAttack()</script><a href="javascript:alert(1)">Bad link</a>']);
    $this->get('/stcecilias/venue-hire')->assertSuccessful()->assertSee('Safe copy')->assertDontSee('<script>titleAttack()', false)->assertDontSee('<script>bodyAttack()', false)->assertDontSee('href="javascript:', false);
});

it('preserves editorial changes when the milestone is reseeded', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    StceciliasPage::where('slug', 'home')->update(['title' => 'Sarah’s edited title']);
    $this->seed(StceciliasMuseumSeeder::class);
    expect(StceciliasPage::count())->toBe(4)->and(StceciliasEvent::count())->toBe(11);
    expect(StceciliasPage::where('slug', 'home')->first()->title)->toBe('Sarah’s edited title');
});

it('requires authentication for the museum editors', function (): void {
    $this->get('/admin/stcecilias-pages')->assertRedirect();
    $this->get('/admin/stcecilias-events')->assertRedirect();
});

it('allows an authorized editor to edit public page content and validates slugs', function (): void {
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $page = StceciliasPage::factory()->create(['slug' => 'venue-hire']);
    Livewire::test(ManageStceciliasPages::class)
        ->callAction(TestAction::make('edit')->table($page), data: ['title' => 'Edited venue title', 'slug' => 'venue-hire', 'is_visible' => true, 'navigation_order' => 0])
        ->assertHasNoActionErrors();
    $this->get('/stcecilias/venue-hire')->assertSee('Edited venue title');
    Livewire::test(ManageStceciliasPages::class)
        ->callAction(TestAction::make('edit')->table($page), data: ['slug' => 'unroutable-page'])
        ->assertHasActionErrors(['slug']);
});

it('rejects events ending before their start and accepts editing a booking link', function (): void {
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $event = StceciliasEvent::factory()->create();
    Livewire::test(ManageStceciliasEvents::class)
        ->callAction(TestAction::make('edit')->table($event), data: ['starts_at' => '2026-11-20 15:00:00', 'ends_at' => '2026-11-20 14:00:00'])
        ->assertHasActionErrors(['ends_at']);
    Livewire::test(ManageStceciliasEvents::class)
        ->callAction(TestAction::make('edit')->table($event), data: ['booking_url' => 'https://example.com/tickets'])
        ->assertHasNoActionErrors();
    expect($event->fresh()->booking_url)->toBe('https://example.com/tickets');
});

it('renders the BSL video and source pricing through the editable sections', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $this->get('/stcecilias/planning-your-visit')->assertSuccessful()
        ->assertSee('Visitor information in British Sign Language')->assertSee('<video', false)
        ->assertSee('guides.bloombergconnects.org', false);
    $this->get('/stcecilias/venue-hire')->assertSuccessful()->assertSee('£216')->assertSee('£1050')->assertSee('Venue Hire Terms and Conditions');
});

it('denies museum administration to users outside the configured admin list', function (): void {
    $this->actingAs(User::factory()->create());
    config(['filament.admin_emails' => []]);
    $this->get('/admin/stcecilias-pages')->assertForbidden();
    $this->get('/admin/stcecilias-events')->assertForbidden();
});

it('shows practical information before the hero and puts events before editorial content', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $this->get('/stcecilias')->assertSuccessful()->assertSeeInOrder([
        'Free admission', 'Tuesday–Saturday, 10:00–17:00', 'A living museum of music',
        'See what’s on', 'id="whats-on"', 'Music, history and discovery',
    ], false)->assertSee('Footer useful links')->assertSee('SCHEvents@ed.ac.uk');
});

it('uses the visitor editor as the single source for hours and admission across all four pages', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $page = StceciliasPage::where('slug', 'planning-your-visit')->firstOrFail();
    Livewire::test(ManageStceciliasPages::class)
        ->callAction(TestAction::make('edit')->table($page), data: [
            'visitor_information' => [
                'opening_hours' => 'Wednesday–Saturday, 11:00–16:00',
                'admission' => 'Free entry for everyone',
                'address' => '50 Niddry Street, Edinburgh',
                'notice' => 'Closed for maintenance on 10 November.',
            ],
        ])->assertHasNoActionErrors();
    foreach (['/stcecilias', '/stcecilias/planning-your-visit', '/stcecilias/venue-hire', '/stcecilias/whats-on'] as $path) {
        $this->get($path)->assertSuccessful()->assertSee('Wednesday–Saturday, 11:00–16:00')->assertSee('Free entry for everyone')->assertSee('Closed for maintenance on 10 November.');
    }
});

it('makes venue pricing tables named keyboard-accessible scroll regions', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $this->get('/stcecilias/venue-hire')->assertSuccessful()
        ->assertSee('tabindex="0" role="region" aria-label="Sypert Concert Room pricing (Laigh Hall included if needed) — scroll to see all columns"', false)
        ->assertSee('tabindex="0" role="region" aria-label="Laigh Hall pricing — scroll to see all columns"', false);
});
