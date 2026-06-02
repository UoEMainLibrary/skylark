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
        ->toContain('background-to-the-resp-26-3-26.docx')
        ->toContain('target="_blank"')
        ->toContain('rel="noopener"')
        ->toContain('(opens in a new tab)')
        ->not->toContain('download');
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
