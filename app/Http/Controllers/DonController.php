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
       $dons = Don::all();

       return response()->json([
               'dons' => $dons
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
        $validator = Validator::make($request->all(),
        [
            'adresse' => 'required',
            'id_user' => 'required',
        ]);
        
        if($validator->fails())
        {
            return response()->json(
                [
                    'request' => $request->all(),
                    'validation' => $validator->errors()
                ]
                );
        }
        else
        {
            //creer un nouveau don
            $don = new Don(['adresse' => $request->input('adresse')]);
            
            $user = User::find($request->input('id_user'));
            $typesang = $user->typesang;
            
            $don->user()->associate($user);
            $don->typesang()->associate($typesang);
            $don->save();


            $dons = $user->dons;
            return response()->json([
                'user' => $user,
                'typesang' => $typesang,
                'msg' => 'Don sauveguarder avec succes',
                'don' => $don
            ]);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
