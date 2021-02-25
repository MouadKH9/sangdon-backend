<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
            'ville_id' => 'required|exists:villes,id',
            'type_sang_id' => 'required|exists:type_sangs,id',
        ]);

        $demande = new Demande([
            'id_user' => Auth::id(),
            'id_ville' => $request->get('ville_id'),
            'id_type_sang' => $request->get('type_sang_id'),
        ]);

        $demande->save();

        return response($demande);
    }

    public function getAll()
    {
        $user = Auth::user();

        $demandes = DB::table('demandes');
        if ($user->type_sang_id != null)
            $demandes = $demandes->where('id_type_sang', $user->type_sang_id);

        if ($user->ville_id !== null)
            $demandes = $demandes->where("id_ville", $user->ville_id);

        return response($demandes->get());
    }

    public function showList($id_user)
    {
        $demande = DB::table('demandes')->where('id_user', $id_user)->get();

        return response($demande);
    }

    public function mesDemandes()
    {
        $demande = DB::table('demandes')->where('id_user', Auth::id())->get();

        return response($demande);
    }

    public function getDemandeById($id_dem)
    {
        $demande = DB::table('demandes')->where('id', $id_dem)->get();

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
