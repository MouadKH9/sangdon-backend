<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\demande;
use Illuminate\Support\Facades\DB;
class demandeController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
            'adress'=>'required',
            'stat'     =>'required'
        ]);

        $demande = new demande([

            'id_dem' => $request->get('id_dem'),
            'adress' => $request->get('adress'),
            'stat'   => $request->get('stat'),
            'id_user'=> 1
        ]);
        $demande ->save();
    }

    public function showList($id_user)
    {
        $demande =DB::table('demandes')->where('id_user', $id_user)->get();
        return $demande;
    }

    public function getDemandeById($id_dem)
    {
        $demande =DB::table('demandes')->where('id_dem', $id_dem)->get();
        return $demande;
    }

    public function update(Request $request, $id_dem)
    {
        $this->validate($request, [
            'adress'=>'required',
            'stat'     =>'required'
        ]);
        $demande= demande::find($id_dem);
        $demande->adress = $request->get('adress');
        $demande->stat = $request->get('stat');
        $demande->save();

    }
}
