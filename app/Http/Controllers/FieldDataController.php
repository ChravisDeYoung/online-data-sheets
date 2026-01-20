<?php

namespace App\Http\Controllers;

use App\Http\Requests\FieldDataHistoryRequest;
use App\Models\FieldData;
use Illuminate\View\View;

/**
 * Controller responsible for field data history.
 */
class FieldDataController extends Controller
{
    /**
     * Display history of the resource.
     *
     * @param FieldDataHistoryRequest $request The request object containing the field data history parameters.
     * @return View The view for displaying the field data history.
     */
    public function history(FieldDataHistoryRequest $request): View
    {
        $attributes = $request->validated();

        $fieldData = FieldData::firstOrNew([
            'field_id' => $attributes['field_id'],
            'page_date' => $attributes['page_date'],
            'column' => $attributes['column']
        ]);

        return view('field_data_histories.table', [
            'fieldDataHistories' => $fieldData->fieldDataHistories()
                ->select('id', 'new_value', 'created_at', 'user_id')
                ->with('user:id,first_name,last_name')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
