<?php

namespace App\Http\Controllers;

use App\Models\FieldData;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsible for field data history.
 */
class FieldDataController extends Controller
{
    /**
     * Display history of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function history(Request $request): View
    {
        $fieldData = FieldData::firstOrNew([
            'field_id' => $request->input('field_id'),
            'page_date' => $request->input('page_date'),
            'column' => $request->input('column')
        ]);

        return view('field_data_histories.table', [
            'field' => $fieldData->field,
            'fieldDataHistories' => $fieldData->fieldDataHistories()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
