<?php

namespace App\Http\Controllers;

use App\Models\EarningType;
use App\Http\Requests\StoreEarningTypeRequest;
use App\Http\Requests\UpdateEarningTypeRequest;

class EarningTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreEarningTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEarningTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EarningType  $earningType
     * @return \Illuminate\Http\Response
     */
    public function show(EarningType $earningType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EarningType  $earningType
     * @return \Illuminate\Http\Response
     */
    public function edit(EarningType $earningType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEarningTypeRequest  $request
     * @param  \App\Models\EarningType  $earningType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEarningTypeRequest $request, EarningType $earningType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EarningType  $earningType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EarningType $earningType)
    {
        //
    }
}
