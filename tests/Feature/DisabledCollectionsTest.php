<?php

it('serves bodylanguage normally when DISABLED_COLLECTIONS is empty', function (): void {
    config(['collections.disabled' => []]);

    $this->get('/bodylanguage')
        ->assertSuccessful()
        ->assertDontSee('temporarily unavailable', false);
});

it('returns 503 with the unavailable page when a collection is listed in DISABLED_COLLECTIONS', function (): void {
    config(['collections.disabled' => ['bodylanguage']]);

    $this->get('/bodylanguage')
        ->assertStatus(503)
        ->assertHeader('Retry-After', '3600')
        ->assertSee('temporarily unavailable', false)
        ->assertSee('University Collections homepage', false);
});

it('disables nested collection URLs as well as the homepage', function (): void {
    config(['collections.disabled' => ['bodylanguage']]);

    $this->get('/bodylanguage/search/*:*')->assertStatus(503);
    $this->get('/bodylanguage/about')->assertStatus(503);
});

it('parses comma-separated DISABLED_COLLECTIONS keys from config', function (): void {
    // Mirrors config/collections.php env parsing without reloading dotenv.
    $disabled = array_values(array_filter(array_map(
        static fn (string $name): string => trim($name),
        explode(',', 'bodylanguage, anatomy'),
    )));

    expect($disabled)->toBe(['bodylanguage', 'anatomy']);

    config(['collections.disabled' => $disabled]);

    $this->get('/bodylanguage')->assertStatus(503);
    $this->get('/anatomy')->assertStatus(503);
    $this->get('/calendars')->assertSuccessful();
});
