<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreFieldDataRequest;
use App\Models\FieldData;

class FieldDataController extends Controller
{
    public function store(StoreFieldDataRequest $request)
    {
        $fieldData = FieldData::create($request->mappedAttributes());

        return response()->json([
            'fieldData' => $fieldData->id,
            'message' => 'Field data created successfully.',
        ], 201);
    }
}
