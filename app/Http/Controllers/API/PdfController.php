<?php

namespace App\Http\Controllers\API;

use setasign\Fpdi\Tcpdf\Fpdi;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Com\Tecnick\Color\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    //
    
    public function signPdf($id, Request $reqest)
    {
$doc=Document::find($id);
if($doc == null){
    return response()->json([
        'message' => 'Document does not exist',
    ],404);
}

$pdf = new Fpdi('L', 'mm', 'A4','A3'); //FPDI extends TCPDF
$pdfFilePath = storage_path('app'.DIRECTORY_SEPARATOR.$doc->file);

$pages = $pdf->setSourceFile($pdfFilePath);


$certificate = 'file://'.base_path(str_replace('/',DIRECTORY_SEPARATOR,'storage/app/certificate/tcpdf.crt'));

$qrpath = str_replace('/',DIRECTORY_SEPARATOR,storage_path('app/qrcode/qrcode.png'));
QrCode::format('png')
    ->color(46,75,113)
    ->eyeColor(0,235, 143, 52,0,0,0)
    ->eyeColor(1,235, 143, 52,0,0,0)
    ->eyeColor(2,235, 143, 52,46,75,113)
    // ->style('dot')
    ->merge(public_path('logo.png'),0.3,true)
    ->generate(env('QR_URL').'/get-document/'.$doc->id,$qrpath);
    
//$key = 'file://storage/app/certificate/key.pem';

// set additional information

for ($i = 1; $i <= $pages ; $i++)
    {
        $pdf->AddPage();
        $page = $pdf->importPage($i);
        $pdf->useTemplate($page, 0, 0);

       if( $i == $pages){
        // set document signature
        $pdf->Image($qrpath,230, 150, 30, 30);
        $pdf->setSignature($certificate, $certificate, 'authentificated', '', 2); 
        $pdf->setSignatureAppearance(230, 150, 30, 30);
       }             
}
$sp=str_replace('uploads','signed',$doc->getRawOriginal('file'));
$signedPdfPath = storage_path('app'.DIRECTORY_SEPARATOR.$sp);
$pdf->Output($signedPdfPath, 'F');
 
// Mise à jour du champ signedfile dans la base de données
 $doc->signedfile = $sp;
 $doc->save();
echo "PDF Generated Successfully";

//supprimer le qrcode
unlink($qrpath);
    }
}
