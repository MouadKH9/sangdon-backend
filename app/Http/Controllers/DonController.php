<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\TypeSang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DonController extends Controller
{
    /**
     * consulter les dons d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response()->json([
               'dons' => Don::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);
        //creer un nouveau don
        $don = new Don(['adresse' => $validated['adresse']]);
        
        $user = User::find($validated['id_user']);
        $type_sang = $user->type_sang;
        
        $don->user()->associate($user);
        $don->type_sang()->associate($type_sang);
        $don->save();

        return response()->json([
            'msg' => 'Don sauveguarder avec succes',
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $dons = $user->dons;

        return response()->json([
            'dons' => $dons,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'adresse' => 'required|max:255',
        ]);

        $don = Don::findOrFail($id);

        $don->adresse = $validated['adresse'];

        $don->save();

        return response()->json([
            'don' => $don,
            'msg' => 'don modifier avec succes'

        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $don = Don::findOrFail($id);

        $don->delete();

        return response()->json([
            'msg' => 'don supprimer avec succes'
        ]);
    }


    private function validated(Request $request)
    {
        $validated = $request->validate([
            'adresse' => 'required|max:255',
            'id_user' => 'required'
        ]);

        return $validated;
    }
}
