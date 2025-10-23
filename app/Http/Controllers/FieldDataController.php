<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\V1\StoreFieldDataRequest;
use App\Http\Requests\UpdateFieldDataRequest;
use App\Models\FieldData;

class FieldDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \App\Http\Requests\Api\V1\StoreFieldDataRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\FieldData $fieldData
     * @return \Illuminate\Http\Response
     */
    public function show(FieldData $fieldData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\FieldData $fieldData
     * @return \Illuminate\Http\Response
     */
    public function edit(FieldData $fieldData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateFieldDataRequest $request
     * @param \App\Models\FieldData $fieldData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldDataRequest $request, FieldData $fieldData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\FieldData $fieldData
     * @return \Illuminate\Http\Response
     */
    public function destroy(FieldData $fieldData)
    {
        //
    }
}
