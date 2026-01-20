<?php

namespace App\Http\Controllers;

use App\Http\Requests\FieldRequest;
use App\Models\Field;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
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
            'fields' => Field::select('id', 'name', 'type', 'subsection', 'page_id')
                ->with('page:id,name')
                ->orderBy('subsection_sort_order')
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
        return view('fields.create', [
            'fieldTypes' => Field::getTypes(),
            'pages' => Page::select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created Field in storage.
     *
     * @param FieldRequest $request The request object containing the field data.
     * @return RedirectResponse The redirect response after storing the Field.
     */
    public function store(FieldRequest $request): RedirectResponse
    {
        Field::create($request->validated());

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
        return view('fields.edit', [
            'field' => $field,
            'fieldTypes' => Field::getTypes(),
            'pages' => Page::select('id', 'name')->get()
        ]);
    }

    /**
     * Update the specified Field in storage.
     *
     * @param FieldRequest $request The request object containing the updated field data.
     * @param Field $field The Field to be updated.
     * @return RedirectResponse The redirect response after updating the Field.
     */
    public function update(FieldRequest $request, Field $field): RedirectResponse
    {
        $field->update($request->validated());

        return redirect()
            ->route('fields.index')
            ->with([
                'status' => 'success',
                'message' => 'Field updated'
            ]);
    }
}
