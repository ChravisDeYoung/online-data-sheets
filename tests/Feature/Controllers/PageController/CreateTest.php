<?php

use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('pages.create'))
        ->assertredirect(route('login'));
});

