<?php

namespace App\Http\Controllers;

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
        $beacons = Beacon::get();
        return view("/beacons/index", compact("beacons"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/beacons/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Beacon::create([
            'name' => $request->get('name'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
        ]);

        return redirect("/beacons");
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beacon  $beacon
     * @return \Illuminate\Http\Response
     */
    public function edit(Beacon $beacon)
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
