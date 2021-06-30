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
            'description' => $request->get('description'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'rotation' => json_encode([
                'x' => doubleval($request->get('rotationX')),
                'y' => doubleval($request->get('rotationY')),
                'z' => doubleval($request->get('rotationZ')),
            ]),
            'icon' => ($request->hasFile('icon') ? $request->file('icon')->storeAs(
                'icons',
                $request->file('icon')->getClientOriginalName(),
                'public'
            ) : null),
        ]);

        #'icon' => ($request->hasFile('icon') ? $request->file('icon')->store('icons', 'public') : null),

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
        $beacon->delete();

        return redirect()->route('beacons.index');
    }
}
