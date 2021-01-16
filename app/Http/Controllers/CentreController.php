<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Centre::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        $centre = new Centre;
        $centre->name = $validated['name'];
        $centre->address = $validated['address'];
        $centre->ville_id = $validated["ville_id"];

        $centre->save();

        return response($centre);
    }

    public function show(Centre $centre)
    {
        return response($centre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Centre  $centre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Centre $centre)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        $centre->name = $validated['name'];
        $centre->address = $validated['address'];
        $centre->ville_id = $validated["ville_id"];

        $centre->save();

        return response($centre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Centre  $centre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Centre $centre)
    {
        $centre->delete();
        return response(["success" => true]);
    }
}
