<?php

test('not use debug function in code', function () {
    expect(['dd', 'dump'])->not->toBeUsed();
});

test('not use Validator Facade in code', function () {
    expect(\Illuminate\Support\Facades\Validator::class)
        ->not->toBeUsed()->ignoring('App\Actions\Fortify');
});
