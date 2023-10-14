<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $etudiants = Etudiant::with('user')->get();
        return response()->json($etudiants);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    { 
        // 'nom_etudiant', 'prenom_etudiant', 'genre', 'date_de_naissance', 'annee_dentree', 'photo', 'user_id'
        $val=Validator::make($request->all(),
        [
            'nom'=>'required|string|max:45',
            'prenom'=>'required|string|max:45',
            'genre'=>'required|string|in:M,F',
            'date_de_naissance'=>'required|date',
            'annee_dentree'=>'required|integer|min:2020|max:2023',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'user_id'=>'integer',
        ]
    );

    if( $val->fails()){
        return response()->json($val->errors(), 422);     
    }
        $fileName = $request->photo->getClientOriginalName();
        $filePath = str_replace('/',DIRECTORY_SEPARATOR,'images/'. $fileName);
        $path = Storage::disk('local')->put($filePath, file_get_contents($request->photo));
        $path = Storage::disk('local')->url($path);
   
        $etudiant = Etudiant::create([
            'nom'=> $request->nom,
            'prenom'=>$request->prenom,
            'genre'=>$request->genre,
            'date_de_naissance'=>$request->date_de_naissance,
            'annee_dentree'=>$request->annee_dentree,
            'photo'=>$filePath,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json($etudiant, 201); 
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        //
        $etudiant = Etudiant::with('user')->get();
        return response()->json($etudiant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        //
        $this->validate($request, [
            'nom'=>'required|string|max:45',
            'prenom'=>'required|string|max:45',
            'genre'=>'required|string|in:M,F',
            'date_de_naissance'=>'required|date',
            'annee_dentree'=>'required|integer|min:2020|max:2023',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'user_id'=>'required|integer',
        ]);

        $etudiant->update([
            'nom'=> $request->nom,
            'prenom'=>$request->prenom,
            'genre'=>$request->genre,
            'date_de_naissance'=>$request->date_de_naissance,
            'annee_dentree'=>$request->annee_dentree,
            'photo'=>$request->photo,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        //
        $etudiant->delete();

        return response()->json();
    }
}
