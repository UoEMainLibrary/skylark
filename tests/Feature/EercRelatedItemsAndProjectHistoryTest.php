<?php

use App\Models\CmsPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);

it('matches legacy skylight related fields for interviewee sibling records', function (): void {
    expect(config('collections.eerc.related_fields'))->toBe([
        'Parent' => 'parent',
    ]);
});

it('renders the project history background document link in a new tab', function (): void {
    $html = view('eerc-v2.pages.project_history', [
        'cmsEnabled' => false,
        'cms' => null,
        'subjectFacet' => ['terms' => []],
        'personFacet' => ['terms' => []],
    ])->render();

    expect($html)
        ->toContain('background-to-the-resp-26-3-26.pdf')
        ->toContain('target="_blank"')
        ->toContain('rel="noopener"')
        ->toContain('(opens in a new tab)')
        ->not->toContain('download')
        ->not->toContain('background-to-the-resp-26-3-26.docx');
});

it('renders the full eerc accessibility statement from the legacy static page', function (): void {
    config(['skylight.resp_skin_version' => 2, 'cms.enabled' => false]);

    $response = $this->get('/eerc/accessibility')->assertSuccessful();

    $response
        ->assertSee('Regional Ethnology of Scotland Project (front-facing) website', false)
        ->assertSee('Public Sector Body (Websites and Mobile Applications)', false)
        ->assertSee('Information.systems@ed.ac.uk', false)
        ->assertSee('WCAG 2.2 AA', false)
        ->assertSee('Contact Scotland BSL', false)
        ->assertSee('Disproportionate burden', false)
        ->assertSee('Preparation of this accessibility statement', false)
        ->assertSee('Change log', false)
        ->assertSee('prepared on', false)
        ->assertSee('September 2021', false)
        ->assertSee('last reviewed on', false)
        ->assertSee('September 2024', false)
        ->assertDontSee('aim to meet WCAG 2.1 Level AA', false);
});

it('updates seeded project history cms content to open the document in a new tab', function (): void {
    $migration = 'database/migrations/2026_06_02_062545_update_eerc_project_history_cms_doc_link.php';
    $docxUrl = asset('collections/eerc/documents/background-to-the-resp-26-3-26.docx');

    Artisan::call('migrate:rollback', [
        '--path' => $migration,
        '--force' => true,
    ]);

    CmsPage::query()->create([
        'collection' => CmsPage::COLLECTION_EERC,
        'slug' => 'project-history',
        'title' => 'Project History',
        'body' => <<<HTML
<p>You can <a href="{$docxUrl}" download>read more about the EERC, RESP and the Archive Project</a> here.</p>
HTML,
    ]);

    Artisan::call('migrate', [
        '--path' => $migration,
        '--force' => true,
    ]);

    $body = CmsPage::lookup(CmsPage::COLLECTION_EERC, 'project-history')?->body;

    expect($body)
        ->toContain('target="_blank"')
        ->toContain('rel="noopener"')
        ->toContain('(opens in a new tab)')
        ->not->toContain('download');
});

it('updates seeded project history cms content to use the pdf background document', function (): void {
    $migration = 'database/migrations/2026_06_15_115515_update_eerc_project_history_cms_doc_to_pdf.php';
    $docxUrl = asset('collections/eerc/documents/background-to-the-resp-26-3-26.docx');

    Artisan::call('migrate:rollback', [
        '--path' => $migration,
        '--force' => true,
    ]);

    CmsPage::query()->create([
        'collection' => CmsPage::COLLECTION_EERC,
        'slug' => 'project-history',
        'title' => 'Project History',
        'body' => <<<HTML
<p>You can <a href="{$docxUrl}" target="_blank" rel="noopener">read more about the EERC, RESP and the Archive Project<span class="sr-only"> (opens in a new tab)</span></a> here.</p>
HTML,
    ]);

    Artisan::call('migrate', [
        '--path' => $migration,
        '--force' => true,
    ]);

    $body = CmsPage::lookup(CmsPage::COLLECTION_EERC, 'project-history')?->body;

    expect($body)
        ->toContain('background-to-the-resp-26-3-26.pdf')
        ->not->toContain('background-to-the-resp-26-3-26.docx');
});
