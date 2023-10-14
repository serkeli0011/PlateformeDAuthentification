<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EcoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ecoles=Ecole::all();
        return response()->json($ecoles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $val=Validator::make($request->all(),
        [
            'nom_ecole'=>'required|string|max:20',
            'code_ecole'=>'required|string|max:20',
            'adresse_ecole'=>'required|string|max:45',
            // 'certificat'=>'required|mimes:pdf',
            'parent_id'=>'nullable|integer',
        ] 
    );

    if( $val->fails()){
        return response()->json($val->errors(), 422);     
    }

    $fileName = $request->file->getClientOriginalName();
    $filePath = 'certificats/' . $fileName;

        $path = Storage::disk('local')->put($filePath, file_get_contents($request->certificat));
        $path = Storage::disk('local')->url($path);
    
        $ecole = Ecole::create([
            'nom_ecole'=> $request->nom_ecole,
            'code_ecole'=>$request->code_ecole,
            'adresse_ecole'=>$request->adresse_ecole,
            // 'certificat'=>$fileName,
            'parent_id'=>$request->parent_id,
        ]);

        return response()->json($ecole,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Ecole $ecole)
    {
        //
        return response()->json($ecole);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ecole $ecole)
    {
        //
        $this->validate($request,[
            'nom_ecole'=>'required|string|max:20',
            'code_ecole'=>'required|string|max:20',
            'adresse_ecole'=>'required|string|max:45',
            // 'certificat'=>'required|string|max:45',
            'parent_id'=>'nullable|integer',
        ]);

        $ecole->update([
            'nom_ecole'=> $request->nom_ecole,
            'code_ecole'=>$request->code_ecole,
            'adresse_ecole'=>$request->adresse_ecole,
            // 'certificat'=>$request->certificat,
            'parent_id'=>$request->parent_id,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ecole $ecole)
    {
        //
        $ecole->delete();
        return response()->json();
    }
}
