<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $verifications = Verification::all();
        return response()->json($verifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //'diplome_id', 'nom_verif', 'email_verif'
        $this->validate($request,[
            'diplome_id'=>'required|integer',
            'nom_verif'=>'required|string|',
            'email_verif'=>'required|string',
        ]);

        $val=Validator::make($request->all(),
        [
            'diplome_id'=>'required|integer',
            'nom_verif'=>'required|string|',
            'email_verif'=>'required|string',
        ]
        );

        if( $val->fails()){
            return view('verification.error',["erreurs"=>$val->errors()]);     
        }

        $verification = Verification::create([
            'diplome_id'=>$request->diplome_id,
            'nom_verif'=>$request->nom_verif,
            'email_verif'=>$request->email_verif,
        ]);

        return view('verification.success',["email"=>$request->email_verif]);
    }
    public function store(Request $request)
    {
        //'diplome_id', 'nom_verif', 'email_verif'
        $this->validate($request,[
            'diplome_id'=>'required|integer',
            'nom_verif'=>'required|string|',
            'email_verif'=>'required|string',
        ]);

        $val=Validator::make($request->all(),
        [
            'diplome_id'=>'required|integer',
            'nom_verif'=>'required|string|',
            'email_verif'=>'required|string',
        ]
        );

        if( $val->fails()){
            return response()->json($val->errors(), 422);     
        }

        $verification = Verification::create([
            'diplome_id'=>$request->diplome_id,
            'nom_verif'=>$request->nom_verif,
            'email_verif'=>$request->email_verif,
        ]);

        return response()->json($verification,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Verification $verification)
    {
        //
        return response()->json($verification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Verification $verification)
    {
        //
        $this->validate($request,[
            'diplome_id'=>'required|integer',
            'nom_verif'=>'required|string|',
            'email_verif'=>'required|string',
        ]);

        $verification->update([
            'diplome_id'=>$request->diplome_id,
            'nom_verif'=>$request->nom_verif,
            'email_verif'=>$request->email_verif,
        ]);

        return response()->json();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Verification $verification)
    {
        //
        $verification->delete();
        return response()->json();
    }
}
