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

it('requires a valid minimum', function ($value) {
    $fieldData = Field::factory()
        ->make([
            'type' => $value === 5 ? Field::TYPE_TEXT : Field::TYPE_NUMBER,
            'minimum' => $value,
            'maximum' => 10,
        ])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('minimum');
})
    ->with([11, 'test', 5]);

it('requires a valid maximum', function ($value) {
    $fieldData = Field::factory()
        ->make([
            'type' => $value === 15 ? Field::TYPE_TEXT : Field::TYPE_NUMBER,
            'minimum' => 10,
            'maximum' => $value,
        ])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('maximum');
})
    ->with([9, 'test', 15]);

it('requires a valid select_options', function ($value) {
    $fieldData = Field::factory()
        ->make([
            'select_options' => $value,
            'type' => $value === 'valid format,wrong type' ? Field::TYPE_TEXT : Field::TYPE_SELECT,
        ])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('fields.store'), $fieldData)
        ->assertInvalid('select_options');
})
    ->with([9, 1.5, true, null, 'invalid format 1,', ',invalid format 2', 'valid format,wrong type']);
