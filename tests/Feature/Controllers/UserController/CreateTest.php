<?php

use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('users.create'))
        ->assertredirect(route('login'));
});

