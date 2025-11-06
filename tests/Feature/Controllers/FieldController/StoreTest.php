<?php

use App\Models\Field;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('requires authentication', function () {
    $fieldData = Field::factory()->make()->toArray();

    post(route('fields.store'), $fieldData)
        ->assertRedirect(route('login'));
});

it('can create a field', function () {
    $fieldData = Field::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData);

    assertDatabaseHas(Field::class, $fieldData);
});

it('redirects to the fields index', function () {
    $fieldData = Field::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertRedirect(route('fields.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'New field has been created.'
        ]);
});

it('requires a valid page_id', function ($value) {
    $fieldData = Field::factory()
        ->make(['page_id' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('page_id');
})
    ->with([null, 1, 'invalid-input']);

it('requires a valid name', function ($value) {
    $fieldData = Field::factory()
        ->make(['name' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid type', function ($value) {
    $fieldData = Field::factory()
        ->make(['type' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('type');
})
    ->with([null, -1, 16, 1.5, 'test-string']);

it('requires a valid subsection', function ($value) {
    $fieldData = Field::factory()
        ->make(['subsection' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('subsection');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid subsection_sort_order', function ($value) {
    $fieldData = Field::factory()
        ->make(['subsection_sort_order' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('subsection_sort_order');
})
    ->with([null, -1, 1.5, 'test']);

it('requires a valid sort_order', function ($value) {
    $fieldData = Field::factory()
        ->make(['sort_order' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('sort_order');
})
    ->with([null, -1, 1.5, 'test']);

it('requires a valid required_columns', function ($value) {
    $fieldData = Field::factory()
        ->make(['required_columns' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('required_columns');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256), '12,1515,', 'test,1']);
