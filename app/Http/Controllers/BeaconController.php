<?php

namespace App\Http\Controllers;

use App\Models\Beacon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BeaconController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'icon' => ($request->hasFile('icon') ? $request->file('icon')->storeAs('icons', time() . '-' . $request->file('icon')->getClientOriginalName(), 'public') : null),
            'mtl' => ($request->hasFile('mtl') ? $request->file('mtl')->storeAs('mtl', time() . '-' . $request->file('mtl')->getClientOriginalName(), 'public') : null),
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
        return view('/beacons/show', compact('beacon'));
        //return view('/beacons/show3DViewTest', compact('beacon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beacon  $beacon
     * @return \Illuminate\Http\Response
     */
    public function edit(Beacon $beacon)
    {
        return view('/beacons/edit', compact('beacon'));
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
        $beacon->name = $request->name;
        $beacon->description = $request->description;
        $beacon->lat = $request->lat;
        $beacon->lng = $request->lng;
        $beacon->rotation = json_encode([
            'x' => doubleval($request->get('rotationX')),
            'y' => doubleval($request->get('rotationY')),
            'z' => doubleval($request->get('rotationZ')),
        ]);

        if (isset($request->removeModel) || $request->hasFile('icon')) {
            Storage::disk('public')->delete($beacon->icon);
            $beacon->icon = ($request->hasFile('icon') ? $request->file('icon')->storeAs('icons', time() . '-' . $request->file('icon')->getClientOriginalName(), 'public') : null);
        }

        if (isset($request->removeMTL) || $request->hasFile('mtl')) {
            Storage::disk('public')->delete($beacon->mtl);
            $beacon->mtl = ($request->hasFile('mtl') ? $request->file('mtl')->storeAs('mtl', time() . '-' . $request->file('mtl')->getClientOriginalName(), 'public') : null);
        }

        $beacon->save();

        return redirect()->route('beacons.show', compact('beacon'));
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
