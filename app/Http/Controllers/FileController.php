<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Http\Response;

class FileController extends Controller
{
    //
    public function getSigned($id)
    {
        $doc=Document::find($id);
        if ($doc == null || empty($doc->signedfile)) {
            return response()->json([
                'message' => 'Signed document not found',
            ], 404);
        }
        else if ($doc->confidentiel == true){
            return view('verification',compact('doc','id'));
        }
        else{ 
            $file =  $doc->signedfile;
            $headers = ["Content-type" => "application/pdf"];
            return response()->file(storage_path('app'.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,$file), $headers));
        }

      
    
    // $response = Response::make($file, 200);
    //$response->header('Content-Type', 'application/pdf');
    //return $response; 
    
    }
}
