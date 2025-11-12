<?php

use App\Models\Field;
use App\Models\FieldData;
use function Pest\Laravel\post;

it('does not require authentication', function () {
    $fieldData = FieldData::factory()->create();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $fieldData->value,
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertStatus(200);
});

it('updates existing field data', function () {
    $fieldData = FieldData::factory()->create();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => 'Updated Value',
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertStatus(200)
        ->assertJson([
            'fieldData' => $fieldData->id,
            'message' => 'Field data updated successfully.',
        ]);

    $this->assertDatabaseHas('field_data', [
        'id' => $fieldData->id,
        'value' => 'Updated Value',
    ]);
});

it('creates new field data and history', function () {
    $fieldData = FieldData::factory()->make();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $fieldData->value,
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertStatus(201)
        ->assertJson([
            'message' => 'Field data created successfully.',
        ]);

    $this->assertDatabaseHas('field_data', [
        'value' => $fieldData->value,
    ]);

    $this->assertDatabaseHas('field_data_histories', [
        'old_value' => null,
        'new_value' => $fieldData->value,
    ]);
});

it('responds if value is out of range', function ($value, $isOutOfRange) {
    $field = Field::factory()->create([
        'type' => Field::TYPE_NUMBER,
        'minimum' => 10,
        'maximum' => 20,
    ]);
    $fieldData = FieldData::factory()
        ->withField($field)
        ->create();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $value,
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Field data updated successfully.',
            'isOutOfRange' => $isOutOfRange,
        ]);
})
    ->with([[9, true], [21, true], [15, false]]);

it('requires a valid column', function ($value) {
    $fieldData = FieldData::factory()->make();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $fieldData->value,
        'column' => $value,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertInvalid('column');
})
    ->with([null, 'string', 0, 6.2]);

it('requires a valid field id', function ($value) {
    $fieldData = FieldData::factory()->make();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->$value,
        'value' => $fieldData->value,
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertInvalid('fieldId');
})
    ->with([null, 'string', 0, 6.2, 100]);

it('requires a valid value', function ($value) {
    $fieldData = FieldData::factory()->make();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $value,
        'column' => $fieldData->column,
        'pageDate' => $fieldData->page_date,
    ]))
        ->assertInvalid('value');
})
    ->with([str_repeat('a', 256)]);

it('requires a valid page date', function ($value) {
    $fieldData = FieldData::factory()->make();

    post(route('api.v1.field-data.store', [
        'fieldId' => $fieldData->field_id,
        'value' => $fieldData->value,
        'column' => $fieldData->column,
        'pageDate' => $value,
    ]))
        ->assertInvalid('pageDate');
})
    ->with(['test', 1, 6.2, '2024/01/32', null]);
