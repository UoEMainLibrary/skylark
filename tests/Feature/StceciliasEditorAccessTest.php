<?php

use App\Filament\Resources\CmsPages\Resp\Pages\EditRespCmsPage;
use App\Filament\Resources\StceciliasEvents\Pages\CreateStceciliasEvent;
use App\Filament\Resources\StceciliasEvents\Pages\EditStceciliasEvent;
use App\Filament\Resources\StceciliasPages\Pages\CreateStceciliasPage;
use App\Filament\Resources\StceciliasPages\Pages\EditStceciliasPage;
use App\Filament\Resources\StceciliasPages\Pages\ManageStceciliasPages;
use App\Models\CmsPage;
use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use App\Models\User;
use Database\Seeders\CmsPagesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('restricts museum editors to museum resources including when locally allowed or admin-listed', function (string $environment): void {
    $this->app->detectEnvironment(fn (): string => $environment);
    $user = User::factory()->stceciliasEditor()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);

    $this->get('/admin/stcecilias-pages')->assertSuccessful()->assertSee('St Cecilia’s Hall')->assertDontSee('RESP')->assertDontSee('Public Art');
    $this->get('/admin/stcecilias-events')->assertSuccessful();
    $this->get('/admin/resp/pages')->assertForbidden();
    $this->get('/admin/public-art/pages')->assertForbidden();
    expect($user->isCmsAdministrator())->toBeFalse();
})->with(['local', 'staging']);

it('admits museum editors without adding them to the full administrator allowlist', function (): void {
    config(['filament.admin_emails' => []]);
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $this->get('/admin/stcecilias-pages')->assertSuccessful();
    $this->get('/admin/stcecilias-events')->assertSuccessful();
});

it('keeps full administrator access across all existing sections', function (): void {
    $user = User::factory()->create();
    config(['filament.admin_emails' => [strtoupper($user->email)]]);
    $this->actingAs($user);
    foreach (['/admin/resp/pages', '/admin/public-art/pages', '/admin/stcecilias-pages', '/admin/stcecilias-events'] as $path) {
        $this->get($path)->assertSuccessful();
    }
});

it('denies panel access to an unassigned user outside local development', function (): void {
    config(['filament.admin_emails' => []]);
    $this->actingAs(User::factory()->create());
    foreach (['/admin/resp/pages', '/admin/public-art/pages', '/admin/stcecilias-pages', '/admin/stcecilias-events'] as $path) {
        $this->get($path)->assertForbidden();
    }
});

it('blocks direct legacy edit URLs and Livewire components for a museum editor', function (): void {
    $this->seed(CmsPagesSeeder::class);
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    foreach (['eerc' => 'resp', 'public-art' => 'public-art'] as $collection => $resource) {
        $page = CmsPage::where('collection', $collection)->firstOrFail();
        $this->get('/admin/'.$resource.'/pages/'.$page->id.'/edit')->assertForbidden();
    }
    $page = CmsPage::where('collection', 'eerc')->firstOrFail();
    Livewire::test(EditRespCmsPage::class, ['record' => $page->id])->assertForbidden();
});

it('rechecks legacy editing rights after an administrator becomes a museum editor', function (): void {
    $this->seed(CmsPagesSeeder::class);
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);
    $this->actingAs($user);
    $page = CmsPage::where('collection', 'eerc')->firstOrFail();
    $component = Livewire::test(EditRespCmsPage::class, ['record' => $page->id])->fillForm(['title' => 'Not permitted']);
    $user->cms_role = User::ROLE_STCECILIAS_EDITOR;
    $user->save();
    $component->call('save')->assertForbidden();
    expect($page->fresh()->title)->not->toBe('Not permitted');
});

it('lets a museum editor edit a page and create and edit events', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $page = StceciliasPage::factory()->create(['slug' => 'venue-hire']);
    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->fillForm(['title' => 'New venue copy', 'slug' => 'venue-hire', 'is_visible' => true])
        ->call('save')->assertHasNoFormErrors();
    expect($page->fresh()->title)->toBe('New venue copy');
    Livewire::test(CreateStceciliasEvent::class)
        ->fillForm(['title' => 'New concert', 'slug' => 'new-concert', 'starts_at' => '2026-12-01 12:00:00'])
        ->call('create')->assertHasNoFormErrors();
    $event = StceciliasEvent::where('slug', 'new-concert')->firstOrFail();
    Livewire::test(EditStceciliasEvent::class, ['record' => $event->id])
        ->fillForm(['price' => 'Free'])
        ->call('save')->assertHasNoFormErrors();
    expect($event->fresh()->price)->toBe('Free');
});

it('does not allow role changes through mass assignment', function (): void {
    $editor = User::factory()->stceciliasEditor()->create();
    $editor->fill(['name' => 'Updated name', 'cms_role' => null])->save();
    expect($editor->fresh()->isStceciliasEditor())->toBeTrue()->and($editor->fresh()->name)->toBe('Updated name');
});

it('creates a restricted account with a generated hashed password', function (): void {
    expect(Artisan::call('app:create-stcecilias-editor', ['email' => ' Museum.Demo@example.test ', '--name' => 'Museum demo']))->toBe(0);
    preg_match('/^Password: (.+)$/m', Artisan::output(), $matches);
    $user = User::where('email', 'museum.demo@example.test')->firstOrFail();
    expect($user->isStceciliasEditor())->toBeTrue()
        ->and($user->name)->toBe('Museum demo')
        ->and(strlen($matches[1]))->toBe(24)
        ->and(Hash::check($matches[1], $user->password))->toBeTrue();
});

it('refuses to overwrite an existing administrator or change their password', function (): void {
    $user = User::factory()->create();
    $hash = $user->password;
    $this->artisan('app:create-stcecilias-editor', ['email' => $user->email])->assertFailed();
    expect($user->fresh()->cms_role)->toBeNull()->and($user->fresh()->password)->toBe($hash);
});

it('refuses case variants of an existing email address', function (): void {
    $user = User::factory()->create(['email' => 'Scott.Example@example.test']);
    $this->artisan('app:create-stcecilias-editor', ['email' => 'scott.example@example.test'])->assertFailed();
    expect(User::count())->toBe(1)->and($user->fresh()->cms_role)->toBeNull();
});

it('rejects invalid login details without creating an account', function (): void {
    $this->artisan('app:create-stcecilias-editor', ['email' => 'not-an-email'])->assertFailed();
    expect(User::count())->toBe(0);
});

it('lets administrators and museum editors reorder pages and updates public navigation', function (bool $restricted): void {
    $user = $restricted ? User::factory()->stceciliasEditor()->create() : User::factory()->create();
    config(['filament.admin_emails' => [$user->email], 'stcecilias.museum_enabled' => true]);
    $this->actingAs($user);
    $home = StceciliasPage::factory()->create(['slug' => 'home', 'navigation_order' => 0]);
    $visit = StceciliasPage::factory()->create(['slug' => 'planning-your-visit', 'navigation_order' => 1]);
    $events = StceciliasPage::factory()->create(['slug' => 'whats-on', 'navigation_order' => 2]);
    $venue = StceciliasPage::factory()->create(['slug' => 'venue-hire', 'navigation_order' => 3]);

    Livewire::test(ManageStceciliasPages::class)
        ->assertTableColumnDoesNotExist('navigation_order')
        ->call('toggleTableReordering')
        ->call('reorderTable', [$home->id, $venue->id, $events->id, $visit->id])
        ->assertCanSeeTableRecords([$home, $venue, $events, $visit], inOrder: true)
        ->call('toggleTableReordering');
    Livewire::test(EditStceciliasPage::class, ['record' => $venue->id])
        ->fillForm(['title' => 'Updated venue'])
        ->call('save')->assertHasNoFormErrors();

    expect($venue->fresh()->navigation_order)->toBe(2);
    $this->get('/stcecilias')->assertSuccessful()->assertViewHas('navigation', fn ($navigation): bool => $navigation->pluck('slug')->all() === ['home', 'venue-hire', 'whats-on', 'planning-your-visit']);
})->with([false, true]);

it('does not expose an order field when editing a page', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $page = StceciliasPage::factory()->create(['slug' => 'venue-hire', 'navigation_order' => 7]);
    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->assertFormFieldDoesNotExist('navigation_order');
});

it('opens museum edit and create screens as dedicated authorized pages', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $page = StceciliasPage::factory()->create(['slug' => 'venue-hire']);
    $event = StceciliasEvent::factory()->create();
    $this->get('/admin/stcecilias-pages')->assertSuccessful()->assertSee('/admin/stcecilias-pages/'.$page->id.'/edit', false);
    $this->get('/admin/stcecilias-events')->assertSuccessful()->assertSee('/admin/stcecilias-events/'.$event->id.'/edit', false)->assertSee('/admin/stcecilias-events/create', false);
    foreach (['/admin/stcecilias-pages/'.$page->id.'/edit', '/admin/stcecilias-events/'.$event->id.'/edit', '/admin/stcecilias-events/create'] as $path) {
        $this->get($path)->assertSuccessful();
    }
    $this->actingAs(User::factory()->create());
    config(['filament.admin_emails' => []]);
    foreach (['/admin/stcecilias-pages/'.$page->id.'/edit', '/admin/stcecilias-events/'.$event->id.'/edit', '/admin/stcecilias-events/create'] as $path) {
        $this->get($path)->assertForbidden();
    }
});

it('cannot reorder pages after museum editing access is revoked', function (): void {
    $user = User::factory()->stceciliasEditor()->create();
    config(['filament.admin_emails' => []]);
    $this->actingAs($user);
    $visit = StceciliasPage::factory()->create(['slug' => 'planning-your-visit', 'navigation_order' => 1]);
    $venue = StceciliasPage::factory()->create(['slug' => 'venue-hire', 'navigation_order' => 2]);
    $component = Livewire::test(ManageStceciliasPages::class)->call('toggleTableReordering');
    $user->cms_role = null;
    $user->save();
    $component->call('reorderTable', [$venue->id, $visit->id]);
    expect($visit->fresh()->navigation_order)->toBe(1)->and($venue->fresh()->navigation_order)->toBe(2);
});

it('allows museum editors to delete a page through its edit screen', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $page = StceciliasPage::factory()->create(['slug' => 'tours']);

    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->callAction('delete');

    $this->assertModelMissing($page);
});

it('loads imported past event HTML as editable paragraphs and saves description changes', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $event = StceciliasEvent::factory()->create([
        'starts_at' => '2021-05-07 10:30:00',
        'ends_at' => '2021-05-07 11:30:00',
        'body' => '<div><div><strong>Original description</strong></div></div><p>Booking details.</p>',
    ]);

    Livewire::test(EditStceciliasEvent::class, ['record' => $event->id])
        ->assertFormSet(['body' => '<p><strong>Original description</strong></p><p>Booking details.</p>'])
        ->fillForm(['body' => '<p>Updated description.</p>'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($event->fresh()->body)->toContain('Updated description.');
});

it('lets a museum editor create a page and add it beneath an existing menu item', function (): void {
    config(['stcecilias.museum_enabled' => true]);
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $parent = StceciliasPage::factory()->create(['slug' => 'whats-on', 'is_visible' => true]);

    Livewire::test(CreateStceciliasPage::class)
        ->fillForm([
            'title' => 'Special concert',
            'slug' => 'special-concert',
            'body' => '<p>Concert details.</p>',
            'is_visible' => true,
            'show_in_navigation' => true,
            'navigation_parent_id' => $parent->id,
        ])->call('create')->assertHasNoFormErrors();

    $page = StceciliasPage::where('slug', 'special-concert')->firstOrFail();
    expect($page->navigation_parent_id)->toBe($parent->id);
    $this->get('/stcecilias/special-concert')->assertSuccessful()->assertSee('Concert details.');
});

it('rejects a CMS page address that would overlap a functional route', function (string $slug): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());

    Livewire::test(CreateStceciliasPage::class)
        ->fillForm(['title' => 'New page', 'slug' => $slug])
        ->call('create')->assertHasFormErrors(['slug']);
})->with(['search/example', 'event/example', 'about', 'whats-on/archive']);

it('prevents selecting the homepage as a dropdown parent', function (): void {
    $this->actingAs(User::factory()->stceciliasEditor()->create());
    $home = StceciliasPage::factory()->create(['slug' => 'home']);
    $page = StceciliasPage::factory()->create(['slug' => 'tours']);

    Livewire::test(CreateStceciliasPage::class)
        ->fillForm(['title' => 'New page', 'slug' => 'new-page', 'navigation_parent_id' => $home->id])
        ->call('create')->assertHasFormErrors(['navigation_parent_id']);

    Livewire::test(EditStceciliasPage::class, ['record' => $page->id])
        ->fillForm(['navigation_parent_id' => $home->id])
        ->call('save')->assertHasFormErrors(['navigation_parent_id']);

    expect($page->fresh()->navigation_parent_id)->toBeNull();
    $this->assertDatabaseMissing('stcecilias_pages', ['slug' => 'new-page']);
});
