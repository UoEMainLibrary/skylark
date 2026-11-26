<?php

use App\Filament\Resources\StceciliasEvents\Pages\EditStceciliasEvent;
use App\Filament\Resources\StceciliasPages\Pages\EditStceciliasPage;
use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use App\Models\User;
use Database\Seeders\StceciliasMuseumSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
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
    ['/stcecilias', 'A Live Museum of Music'],
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

it('updates the original homepage and event defaults on reseed', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    StceciliasPage::where('slug', 'home')->update([
        'title' => 'A living museum of music',
        'image_path' => 'stcecilias/concert-room.jpg',
        'image_alt' => 'Musicians in the elliptical Sypert Concert Room. Photograph: Jim Stephenson.',
    ]);
    StceciliasEvent::where('slug', 'volunteer-led-tour-7')->update(['price' => 'Free / Donations appreciated']);

    $this->seed(StceciliasMuseumSeeder::class);

    $this->get('/stcecilias')->assertSee('A Live Museum of Music')->assertSee('gallery-visitors.webp');
    expect(StceciliasEvent::where('slug', 'volunteer-led-tour-7')->value('price'))->toBe('Free / donations appreciated');
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
    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->fillForm(['title' => 'Edited venue title', 'slug' => 'venue-hire', 'is_visible' => true])
        ->call('save')->assertHasNoFormErrors();
    $this->get('/stcecilias/venue-hire')->assertSee('Edited venue title');
    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->fillForm(['slug' => 'unroutable-page'])
        ->call('save')->assertHasNoFormErrors();
    expect($page->fresh()->slug)->toBe('venue-hire');
});

it('rejects events ending before their start and accepts editing a booking link', function (): void {
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $event = StceciliasEvent::factory()->create();
    Livewire::test(EditStceciliasEvent::class, ['record' => $event->id])
        ->fillForm(['starts_at' => '2026-11-20 15:00:00', 'ends_at' => '2026-11-20 14:00:00'])
        ->call('save')->assertHasFormErrors(['ends_at']);
    Livewire::test(EditStceciliasEvent::class, ['record' => $event->id])
        ->fillForm(['booking_url' => 'https://example.com/tickets'])
        ->call('save')->assertHasNoFormErrors();
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
        'Free admission', 'Tuesday–Saturday, 10:00–17:00', 'A Live Museum of Music',
        'See what’s on', 'id="whats-on"', 'Music, history and discovery',
    ], false)->assertSee('gallery-visitors.webp')->assertSee('Visitors looking at string instruments in a gallery display case.')->assertSee('Footer useful links')->assertSee('SCHEvents@ed.ac.uk');
});

it('uses the visitor editor as the single source for hours and admission across all four pages', function (): void {
    $this->seed(StceciliasMuseumSeeder::class);
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $page = StceciliasPage::where('slug', 'planning-your-visit')->firstOrFail();
    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->fillForm([
            'visitor_information' => [
                'opening_hours' => 'Wednesday–Saturday, 11:00–16:00',
                'admission' => 'Free entry for everyone',
                'address' => '50 Niddry Street, Edinburgh',
                'notice' => 'Closed for maintenance on 10 November.',
            ],
        ])->call('save')->assertHasNoFormErrors();
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

it('renders published nested museum pages with local audio and keeps drafts hidden', function (): void {
    StceciliasPage::factory()->create([
        'slug' => 'tours/binks/harpsichords',
        'sections' => [[
            'heading' => 'Audio guide',
            'anchor' => 'listen',
            'audio_url' => '/storage/stcecilias/migration/harpsichords.mp3',
        ]],
        'is_visible' => true,
    ]);
    StceciliasPage::factory()->create(['slug' => 'research', 'is_visible' => false]);

    $this->get('/stcecilias/tours/binks/harpsichords')->assertSuccessful()
        ->assertSee('id="listen"', false)->assertSee('<audio', false)
        ->assertSee('/storage/stcecilias/migration/harpsichords.mp3');
    $this->get('/stcecilias/research')->assertNotFound();
});

it('keeps past events browsable and omits booking links for finished events', function (): void {
    StceciliasPage::factory()->create(['slug' => 'whats-on', 'is_visible' => true]);
    StceciliasEvent::factory()->create([
        'slug' => 'archived-concert',
        'title' => 'Archived concert',
        'starts_at' => now()->subWeek(),
        'ends_at' => now()->subWeek()->addHour(),
        'booking_url' => 'https://example.com/expired-booking',
        'is_visible' => true,
    ]);
    StceciliasEvent::factory()->create([
        'slug' => 'private-concert',
        'is_visible' => false,
    ]);

    $this->get('/stcecilias/whats-on')->assertSuccessful()->assertDontSee('Archived concert');
    $this->get('/stcecilias/whats-on/archive')->assertSuccessful()->assertSee('Archived concert');
    $this->get('/stcecilias/event/archived-concert')->assertSuccessful()
        ->assertSee('Archived concert')->assertDontSee('https://example.com/expired-booking');
    $this->get('/stcecilias/event/private-concert')->assertNotFound();
});

it('rejects staging imports addressed to the production site before reading the bundle', function (): void {
    config(['app.url' => 'https://collections.ed.ac.uk']);

    $this->artisan('app:import-stcecilias-content', ['directory' => '/missing', '--staging' => true])
        ->expectsOutput('Run this from the local SQLite preview or the enabled Collections staging site.')
        ->assertFailed();

    expect(StceciliasPage::count())->toBe(0)->and(StceciliasEvent::count())->toBe(0);
});

it('renders menu children only beneath a published parent and preserves ordinary page access', function (): void {
    StceciliasPage::factory()->create(['slug' => 'home']);
    $parent = StceciliasPage::factory()->create(['slug' => 'whats-on', 'is_visible' => true]);
    StceciliasPage::factory()->create([
        'slug' => 'festival',
        'title' => 'Festival',
        'navigation_label' => 'Summer festival',
        'show_in_navigation' => true,
        'navigation_parent_id' => $parent->id,
        'is_visible' => true,
    ]);
    $this->get('/stcecilias')->assertSuccessful()->assertSee('Summer festival')->assertSee('More in');
    $parent->update(['is_visible' => false]);
    $this->get('/stcecilias')->assertSuccessful()->assertDontSee('Summer festival');
    $this->get('/stcecilias/festival')->assertSuccessful();
});

it('shows blog cards and leaves unpublished articles out', function (): void {
    StceciliasPage::factory()->create(['slug' => 'blog', 'is_visible' => true]);
    StceciliasPage::factory()->create(['slug' => 'blog/story', 'title' => 'Museum story', 'is_visible' => true]);
    StceciliasPage::factory()->create(['slug' => 'blog/draft', 'title' => 'Hidden story', 'is_visible' => false]);

    $this->get('/stcecilias/blog')->assertSuccessful()->assertSee('Museum story')
        ->assertSee('Read more')->assertDontSee('Hidden story');
});

it('links an event back to What’s On without the archive link', function (): void {
    StceciliasPage::factory()->create(['slug' => 'whats-on', 'is_visible' => true]);
    $event = StceciliasEvent::factory()->create(['is_visible' => true]);

    $this->get('/stcecilias/event/'.$event->slug)->assertSuccessful()
        ->assertSee('Back to What’s On')->assertDontSee('Past events');
});

it('prepares old WordPress URLs as permanent redirects to their new destinations', function (): void {
    config(['app.url' => 'https://collections.ed.ac.uk']);
    $this->get('https://www.stcecilias.ed.ac.uk/binks-harpsichord/')
        ->assertRedirect('https://collections.ed.ac.uk/stcecilias/tours/binks/harpsichords')
        ->assertStatus(301);
    $this->get('https://collections.ed.ac.uk/stcecilias/binks-harpsichord')
        ->assertRedirect(url('/stcecilias/tours/binks/harpsichords'))
        ->assertStatus(301);
});

it('rejects self-parenting and nested menu parents', function (): void {
    $parent = StceciliasPage::factory()->create(['slug' => 'about-us']);
    $child = StceciliasPage::factory()->create(['slug' => 'history', 'navigation_parent_id' => $parent->id]);

    expect(fn () => $parent->update(['navigation_parent_id' => $child->id]))
        ->toThrow(ValidationException::class);
    expect(fn () => $child->update(['navigation_parent_id' => $child->id]))
        ->toThrow(ValidationException::class);
});

it('rejects the homepage as a dropdown parent', function (): void {
    $home = StceciliasPage::factory()->create(['slug' => 'home']);
    $page = StceciliasPage::factory()->create(['slug' => 'tours']);

    expect(fn () => $page->update(['navigation_parent_id' => $home->id]))
        ->toThrow(ValidationException::class);
    expect($page->fresh()->navigation_parent_id)->toBeNull();
});

it('uses a migrated article image when a blog card has no manually selected main image', function (): void {
    $post = StceciliasPage::factory()->make([
        'slug' => 'blog/story',
        'image_path' => null,
        'body' => '<p>Story</p><img src="/storage/stcecilias/migration/story.jpg">',
    ]);

    expect($post->blogCardImageUrl())->toBe('/storage/stcecilias/migration/story.jpg');
});
