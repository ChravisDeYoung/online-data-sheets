<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('users.index'))
        ->assertredirect(route('login'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('users.index'))
        ->assertViewIs('users.index');
});

it('shows sorted users', function () {
    User::factory()->create(['first_name' => 'Person A']);
    User::factory()->create(['first_name' => 'Person B']);

    actingAs(User::factory()->create())
        ->get(route('users.index'))
        ->assertSeeInOrder(['Person A', 'Person B']);
});

it('searches users by first name, last name, or email', function () {
    User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@email.com']);
    User::factory()->create(['first_name' => 'Dorothy', 'last_name' => 'Wiggles', 'email' => 'ms_wiggles@email.com']);
    User::factory()->create(['first_name' => 'Peter', 'last_name' => 'Malarkey', 'email' => 'peter@domain.ca']);
    User::factory()->create(['first_name' => 'Kate', 'last_name' => 'Spade', 'email' => 'spades@email.com']);

    actingAs(User::factory()->create())
        ->get(route('users.index', ['search' => 'Do']))
        ->assertSee(['John', 'Dorothy', 'Peter'])
        ->assertDontSee('Kate');
});

