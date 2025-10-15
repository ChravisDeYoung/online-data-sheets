<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\View\View;

class FieldController extends Controller
{
    public function index(): View
    {
        return view('fields.index', ['fields' => Field::orderBy('subsection_sort_order')
            ->orderBy('sort_order')
            ->search(request('search'))
            ->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreFieldRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateFieldRequest $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        //
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
}
