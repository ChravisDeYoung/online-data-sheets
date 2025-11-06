<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsible for managing Fields in the application.
 */
class FieldController extends Controller
{
    /**
     * Display a listing of the Fields.
     *
     * @return View The view for displaying the Fields.
     */
    public function index(): View
    {
        return view('fields.index', [
            'fields' => Field::orderBy('subsection_sort_order')
                ->orderBy('sort_order')
                ->search(request('search'))
                ->paginate(10)]);
    }

    /**
     * Show the form for creating a new Field.
     *
     * @return View The view for creating a new Field.
     */
    public function create(): View
    {
        return view('fields.create');
    }

    /**
     * Store a newly created Field in storage.
     *
     * @return RedirectResponse The redirect response after storing the Field.
     */
    public function store(): RedirectResponse
    {
        $attributes = $this->validateField();

        Field::create($attributes);

        return redirect()
            ->route('fields.index')
            ->with([
                'status' => 'success',
                'message' => 'New field has been created.'
            ]);
    }

    /**
     * Show the form for editing the specified Field.
     *
     * @param Field $field The Field to be edited.
     * @return View The view for editing the Field.
     */
    public function edit(Field $field): View
    {
        return view('fields.edit', ['field' => $field]);
    }

    /**
     * Update the specified Field in storage.
     *
     * @param Request $request The request object containing the updated field data.
     * @param Field $field The Field to be updated.
     * @return RedirectResponse The redirect response after updating the Field.
     */
    public function update(Request $request, Field $field): RedirectResponse
    {
        $validated = $this->validateField($field);

        $field->update($validated);

        return redirect()
            ->route('fields.index')
            ->with([
                'status' => 'success',
                'message' => 'Field updated'
            ]);
    }

    /**
     * Validate the request data for creating or updating a field.
     *
     * @param Field|null $field The field instance being validated, or null if a new instance is being created.
     * @return array The validated data.
     */
    private function validateField(?Field $field = null): array
    {
        $field ??= new Field();

        return request()->validate([
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|string|max:255',
            'type' => 'required|integer|max:15|in:' . implode(',', array_keys(Field::getTypes())),
            'subsection' => 'required|string|max:255',
            'subsection_sort_order' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
            'required_columns' => 'required|string|max:255|regex:/^\d+(,\d+)*$/',
            'minimum' => 'nullable|numeric|prohibited_unless:type,' . Field::TYPE_NUMBER . (request()->filled('maximum') ? '|lt:maximum' : ''),
            'maximum' => 'nullable|numeric|prohibited_unless:type,' . Field::TYPE_NUMBER . (request()->filled('minimum') ? '|gt:minimum' : ''),
            'select_options' => 'nullable|string|max:255|regex:/^[^,]+(,[^,]+)*$/|required_if:type,' . Field::TYPE_SELECT . '|prohibited_unless:type,' . Field::TYPE_SELECT,
        ]);
    }
}
