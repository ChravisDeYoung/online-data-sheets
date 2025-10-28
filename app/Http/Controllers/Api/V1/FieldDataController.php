<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreFieldDataRequest;
use App\Models\FieldData;

class FieldDataController extends Controller
{
    public function store(StoreFieldDataRequest $request)
    {
        $attributes = $request->mappedAttributes();

        $fieldData = FieldData::updateOrCreate(
            ['field_id' => $attributes['field_id'], 'column' => $attributes['column'], 'page_date' => $attributes['page_date']], // what we match on
            ['value' => $attributes['value']]        // data to update or create
        );

        return response()->json([
            'fieldData' => $fieldData->id,
            'message' => $fieldData->wasRecentlyCreated
                ? 'Field data created successfully.'
                : 'Field data updated successfully.',
            'isOutOfRange' => $fieldData->is_out_of_range,
        ], $fieldData->wasRecentlyCreated ? 201 : 200);
    }
}
