<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $documents = Document::with(['user','etudiant','ecole'])->get();
        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
     
      $val=Validator::make($request->all(),
      [
        'filiere' => 'required|string|in:asi,rsi,iabd',
        'niveau' => 'required|string|in:bachelor3,master1,master2,doctorat',
        'intitule' => 'required|string|max:255',
        'type' => 'required|string|in:diplome,bulletin,autre',
        'file' => 'required|mimes:pdf',
        'confidentiel'=>'',
        'signedfile' => 'mimes:pdf',
        'etudiant_id' => 'required|integer',
        'ecole_id' => 'required|integer',
        'user_id' => 'integer',
    ] 
   
);

        if( $val->fails()){
            return response()->json($val->errors(), 422);     
        }
    
       //enregistrer le document non signé
        $fileName = $request->file->getClientOriginalName();
        $filePath = str_replace('/',DIRECTORY_SEPARATOR,'uploads/'. $fileName);
        $path = Storage::disk('local')->put($filePath, file_get_contents($request->file));
        $path = Storage::disk('local')->url($path);
    

        //enregistrer le document signé
        $p = 'hello';
        if ($request->hasFile('signedfile')) {
        $fileName_ = $request->signedfile->getClientOriginalName();
        $filePath_ = str_replace('/',DIRECTORY_SEPARATOR,'signedPdf/'. $fileName_);
        $path_ = Storage::disk('local')->put($filePath_, file_get_contents($request->signedfile));
        $path_ = Storage::disk('local')->url($path_);
        }
        else{$filePath_ = null ;}
        
        // Créer le document dans la base de données
        $document = Document::create([
            'filiere' => $request->filiere,
            'niveau' => $request->niveau,
            'intitule' => $request->intitule,
            'type' => $request->type,
            'file' => $filePath, // Enregistrer le chemin du fichier dans la base de données
            'signedfile' =>$filePath_ ,// Enregistrer le chemin du fichier  signé dans la base de données
            'confidentiel'=>$request->confidentiel,
            'etudiant_id' => $request->etudiant_id,
            'ecole_id' => $request->ecole_id,
            'user_id' => auth()->user()->id,
        ]);
    
        return response()->json($document, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
        $document = Document::with(['user','etudiant','ecole'])->get();
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
        $this->validate($request, [
            'filiere'=>'required|string|in:asi,rsi,iabd',
            'niveau'=>'required|string|in:bachelor3,master1,master2,doctorat',
            'intitule'=>'required|string|max:255',
            'type'=>'required|string|in:diplome,bulletin,autre',
            'file'=>'required|mimes:pdf',
            'signedfile' => 'nullable|mimes:pdf',
            'etudiant_id'=>'required|integer',
            'ecole_id'=>'required|integer',
            'user_id'=>'required|integer',

        ]);

        $document->update([
           
            'filiere'=>$request->filiere,
            'niveau'=>$request->niveau,
            'intitule'=>$request->intitule,
            'type'=>$request->type,
            'file' => $request->file,
            'signedfile' =>$request->signedfile ,
            'etudiant_id'=>$request->id_etudiant,
            'ecole_id'=>$request->id_ecole,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json(); 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
        $document->delete();
        return response()->json();
    }
}
