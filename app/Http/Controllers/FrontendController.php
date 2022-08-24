<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FrontendController extends Controller
{
   public function playMusic(Request $request)
   {
       $path =url('').'/storage/app/public/songs/'. $request->song."";
         
        $response = new BinaryFileResponse($path);
        BinaryFileResponse::trustXSendfileTypeHeader(); 
        return $response; 
      
         // \App::abort(400); 
   }
}
