<?php

use App\Models\RespHomeContent;
use Database\Seeders\RespHomeContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['skylight.resp_skin_version' => 2]);
});

it('renders the eerc v2 home intro from the database when seeded', function (): void {
    $this->seed(RespHomeContentSeeder::class);

    $html = view('eerc-v2.home', [
        'subjectFacet' => [],
        'personFacet' => [],
    ])->render();

    expect($html)->toContain('RESP Archive Project')
        ->and($html)->toContain('Exhibition gallery')
        ->and($html)->toContain('created by the RESP, the project');
});

it('renders stored html from resp home content', function (): void {
    RespHomeContent::query()->create([
        'title' => 'Home',
        'slug' => RespHomeContent::SLUG,
        'body' => '<p>CMS marker unique-string-alpha-99</p>',
    ]);

    $html = view('eerc-v2.home', [
        'subjectFacet' => [],
        'personFacet' => [],
    ])->render();

    expect($html)->toContain('CMS marker unique-string-alpha-99');
});
