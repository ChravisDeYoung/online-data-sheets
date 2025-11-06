<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreFieldDataRequest;
use App\Models\FieldData;
use Illuminate\Http\JsonResponse;

/**
 * Controller responsible for storing field data.
 */
class FieldDataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFieldDataRequest $request The request object containing the field data.
     * @return JsonResponse The JSON response containing the field data ID and message.
     */
    public function store(StoreFieldDataRequest $request): JsonResponse
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
