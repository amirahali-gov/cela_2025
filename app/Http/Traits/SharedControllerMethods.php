<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Upload;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait SharedControllerMethods {

    public function upload(Request $request){
        $data = $request->all();
        $name = $data['name'];
        $folderName = $data['folderName'];
        $description = $data['description'];
        $form = $data['form'];
        $referenceId = $data['id'];
        $ran = rand(0, 999);
        $currentTime = Carbon::now();
        $unique = $ran.'-'.$currentTime->toTimeString();
        Storage::putFileAs('public/chunk/'.$folderName, new File($data['chunk']->path()), $data['count'].'-'.$name.'-'.$unique);

        if($data['final'] === 'true'){
            $files = Storage::files("public/chunk/".$folderName);
            sort($files);
            $ts = str_replace("public/","",$files[0]);
            for($i = 1; $i <= count($files) - 1; $i++){
                $fileName = str_replace("public/","",$files[$i]);
                $oldFile = Storage::disk('public')->get($fileName);
                Storage::disk('public')->append($ts, $oldFile);
            }
            
            $FileNameEnd = str_replace(' ', '_', $data['name']);
            Storage::move($files[0], '/'.$referenceId.'/'.$ran.'-'.$FileNameEnd);
            Storage::deleteDirectory('public/chunk/'.$folderName);

            $newUploads = new Upload();
            $newUploads->UPD_REF_ID = $referenceId;
            $newUploads->UPD_Form = $form;
            $newUploads->UPD_DocName = $data['name'];
            $newUploads->UPD_Desc = $description;
            $newUploads->UPD_FilePath = "/".$referenceId.'/'.$ran.'-'.$FileNameEnd;


            try{
                $newUploads->save();
            }catch(\Exception $e){
                Log::channel('upload')->info("Error for upload (Table {$form} - ID: {$referenceId}): {$e}");
                
                return response()->json(['success' => false],500);
    
            }

            return response()->json(['success' => true, 'final' => $data['final'], 'ts' => $ts, 'count' => count($files)],201);
        }
        
       
        return response()->json(['success' => true, 'final' => $data['final']],200);
    }
}

