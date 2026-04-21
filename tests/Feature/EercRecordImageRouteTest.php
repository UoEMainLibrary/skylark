<?php

use App\Http\Controllers\RecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

it('routes eerc three-part record paths to the bitstream proxy before record show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/eerc/record/999/1/thumbnail.jpg', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('proxyImage');
});
