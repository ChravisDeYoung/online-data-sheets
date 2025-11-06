<?php

use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('fields.create'))
        ->assertredirect(route('login'));
});

