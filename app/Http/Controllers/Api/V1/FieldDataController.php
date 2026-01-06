<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreFieldDataRequest;
use App\Models\FieldData;
use App\Models\FieldDataHistory;
use App\Notifications\FieldDataOutOfRange;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

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

        $fieldData = FieldData::firstOrNew([
            'field_id' => $attributes['field_id'],
            'column' => $attributes['column'],
            'page_date' => $attributes['page_date']
        ]);

        $oldValue = $fieldData->exists ? $fieldData->value : null;

        $fieldData->value = $attributes['value'];
        $fieldData->save();

        $historyCreated = false;
        if ($oldValue !== $attributes['value']) {
            $user = $request->user();

            FieldDataHistory::create([
                'field_data_id' => $fieldData->id,
                'old_value' => $oldValue,
                'new_value' => $attributes['value'],
                'user_id' => $user->id,
            ]);

            $historyCreated = true;

            if ($fieldData->is_out_of_range) {
                Notification::send($fieldData->field->subscribers, new FieldDataOutOfRange($fieldData));
            }
        }

        return response()->json([
            'fieldData' => $fieldData->id,
            'message' => $fieldData->wasRecentlyCreated
                ? 'Field data created successfully.'
                : 'Field data updated successfully.',
            'isOutOfRange' => $fieldData->is_out_of_range,
            'createdHistory' => $request->user()->hasAnyRole(['admin']) && $historyCreated // only admin can see history
        ], $fieldData->wasRecentlyCreated ? 201 : 200);
    }
}
