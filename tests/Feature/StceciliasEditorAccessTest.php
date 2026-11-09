<?php

use App\Filament\Resources\CmsPages\Resp\Pages\EditRespCmsPage;
use App\Filament\Resources\StceciliasEvents\Pages\ManageStceciliasEvents;
use App\Filament\Resources\StceciliasPages\Pages\ManageStceciliasPages;
use App\Models\CmsPage;
use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use App\Models\User;
use Database\Seeders\CmsPagesSeeder;
use Filament\Actions\Testing\TestAction;
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
    Livewire::test(ManageStceciliasPages::class)
        ->callAction(TestAction::make('edit')->table($page), data: ['title' => 'New venue copy', 'slug' => 'venue-hire', 'is_visible' => true, 'navigation_order' => 0])
        ->assertHasNoActionErrors();
    expect($page->fresh()->title)->toBe('New venue copy');
    Livewire::test(ManageStceciliasEvents::class)
        ->callAction('create', data: ['title' => 'New concert', 'slug' => 'new-concert', 'starts_at' => '2026-12-01 12:00:00'])
        ->assertHasNoActionErrors();
    $event = StceciliasEvent::where('slug', 'new-concert')->firstOrFail();
    Livewire::test(ManageStceciliasEvents::class)
        ->callAction(TestAction::make('edit')->table($event), data: ['price' => 'Free'])
        ->assertHasNoActionErrors();
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
