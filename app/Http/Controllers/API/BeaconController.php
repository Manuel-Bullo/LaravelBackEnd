<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Beacon;
use Illuminate\Http\Request;

class BeaconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Beacon::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beacon  $beacon
     * @return \Illuminate\Http\Response
     */
    public function show(Beacon $beacon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beacon  $beacon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beacon $beacon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beacon  $beacon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beacon $beacon)
    {
        //
    }
}
