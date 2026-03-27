<?php

use App\Models\RespHomeContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects the resp home filament index to the edit page and provisions the cms row', function (): void {
    $user = User::factory()->create();
    config(['filament.admin_emails' => [$user->email]]);

    expect(RespHomeContent::query()->count())->toBe(0);

    $response = $this->actingAs($user)->get('/admin/resp/home');

    $record = RespHomeContent::query()->where('slug', RespHomeContent::SLUG)->first();
    expect($record)->not->toBeNull();

    $response->assertRedirect(route('filament.admin.resources.resp.home.edit', [
        'record' => $record,
    ], absolute: false));
});
