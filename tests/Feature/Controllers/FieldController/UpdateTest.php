<?php

use App\Models\Field;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patch;

it('requires authentication', function () {
    $field = Field::factory()->create();

    patch(
        route('fields.update', $field),
        ['name' => 'Updated Name'])
        ->assertRedirect(route('login'));
});

//$table->id();
//$table->timestamps();
//$table->foreignIdFor(Page::class)->constrained()->restrictOnDelete();
//$table->string('name');
//$table->tinyInteger('type')->default(Field::TYPE_TEXT);
//$table->string('subsection');
//$table->integer('subsection_sort_order');
//$table->integer('sort_order');
//$table->decimal('minimum')->nullable();
//$table->decimal('maximum')->nullable();
//$table->string('select_options')->nullable();
//$table->string('required_columns')->default('1');
it('can update a field', function () {
    $page1 = Page::factory()->create();
    $field = Field::factory()->create([
        'page_id' => $page1->id,
        'name' => 'Test Field 1',
        'type' => Field::TYPE_SELECT,
        'subsection' => 'Subsection 1',
        'subsection_sort_order' => 1,
        'sort_order' => 1,
        'required_columns' => '1,3,5',
    ]);

    $page2 = Page::factory()->create();
    $updatedFieldData = [
        'page_id' => $page2->id,
        'name' => 'Test Field 1 (updated)',
        'type' => Field::TYPE_NUMBER,
        'subsection' => 'Subsection 1 (updated)',
        'subsection_sort_order' => 2,
        'sort_order' => 2,
        'required_columns' => '2,4',
//        'minimum' => 1,
//        'maximum' => 10,
//        'select_options' => null,
    ];

    actingAs(User::factory()->create())
        ->patch(route('fields.update', $field), $updatedFieldData);

    assertDatabaseHas(Field::class, $updatedFieldData);
});

it('redirects to the fields index', function () {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['name' => 'Updated Name']))
        ->assertRedirect(route('fields.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'Field updated'
        ]);
});

it('requires a valid page_id', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['page_id' => $value]))
        ->assertInvalid('page_id');
})
    ->with([null, -1, 'invalid-input', 1000]);

it('requires a valid name', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['name' => $value]))
        ->assertInvalid('name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid type', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['type' => $value]))
        ->assertInvalid('type');
})
    ->with([null, -1, 16, 1.5, 'test-string']);

it('requires a valid subsection', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['subsection' => $value]))
        ->assertInvalid('subsection');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid subsection_sort_order', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['subsection_sort_order' => $value]))
        ->assertInvalid('subsection_sort_order');
})
    ->with([null, -1, 1.5, 'test']);

it('requires a valid sort_order', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['sort_order' => $value]))
        ->assertInvalid('sort_order');
})
    ->with([null, -1, 1.5, 'test']);

it('requires a valid required_columns', function ($value) {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('fields.update', $field),
            array_merge($field->toArray(), ['required_columns' => $value]))
        ->assertInvalid('required_columns');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256), '12,1515,', 'test,1']);
