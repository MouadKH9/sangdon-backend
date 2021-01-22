<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
            'adress' => 'required',
            'stat' => 'required'
        ]);

        $demande = new Demande([
            'id_dem' => $request->get('id_dem'),
            'adress' => $request->get('adress'),
            'stat'   => $request->get('stat'),
            'id_user' => 1
        ]);
        $demande->save();

        return response($demande);
    }

    public function showList($id_user)
    {
        $demande = DB::table('demandes')->where('id_user', $id_user)->get();

        return response($demande);
    }

    public function getDemandeById($id_dem)
    {
        $demande = DB::table('demandes')->where('id_dem', $id_dem)->get();

        return response($demande);
    }

    public function update(Request $request, $id_dem)
    {
        $this->validate($request, [
            'adress' => 'required',
            'stat'     => 'required'
        ]);
        $demande = Demande::find($id_dem);
        $demande->adress = $request->get('adress');
        $demande->save();

        return response($demande);
    }

    public function confirmDemande($id)
    {
        $demande = Demande::find($id);
        $demande->stat = true;
        $demande->save();

        return response($demande);
    }
}
