<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FieldController extends Controller
{
    public function index(): View
    {
        return view('fields.index', [
            'fields' => Field::orderBy('subsection_sort_order')
                ->orderBy('sort_order')
                ->search(request('search'))
                ->paginate(10)]);
    }

    public function create(): View
    {
        return view('fields.create');
    }

    public function store()
    {
        $attributes = $this->validateField();

        Field::create($attributes);

        return redirect('/fields')->with([
            'status' => 'success',
            'message' => 'New field has been created.'
        ]);
    }

    public function edit(Field $field): View
    {
        return view('fields.edit', ['field' => $field]);
    }

    public function update(Request $request, Field $field)
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
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }

    private function validateField(?Field $field = null): array
    {
        $field ??= new Field();

        return request()->validate([
            'page_id' => 'required|exists:pages,id',
            'name' => 'required|max:255',
            'type' => 'required|max:15|in:' . implode(',', array_keys(Field::getTypes())),
            'subsection' => 'required|max:255',
            'subsection_sort_order' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
        ]);
    }
}
