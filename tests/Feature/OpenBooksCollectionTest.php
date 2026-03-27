<?php

it('serves the openbooks home page at /openbooks', function () {
    $this->get('/openbooks')->assertSuccessful();
});

it('serves the openbooks home page at / on a configured dedicated host', function () {
    $this->withHeaders(['Host' => 'openbooks.testing'])
        ->get('/')
        ->assertSuccessful();
});
