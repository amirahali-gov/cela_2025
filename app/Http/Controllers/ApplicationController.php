<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Area;
use App\Models\Link;
use App\Models\Upload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function getFormView(){
        $areas = [];
        foreach(Area::all() as $area){
            array_push($areas, [
                $area->Area_CC,
                $area->Board,
            ]);
        }
        return view('ApplicationForm.form', compact('areas'));
    }

    private $validatorRules = [
        'APL_FName' => 'required',
        'APL_MName' => 'nullable',
        'APL_LName' => 'required',
        'APL_Title' => 'required',
        'APL_Address1' => 'required',
        'APL_Address2' => 'required',
        'APL_Address3' => 'required',
        'APL_Municipality' => 'required',
        'APL_Gender' => 'required',
        'APL_DOB' => 'required',
        'APL_PPhone' => 'required',
        'APL_APhone' => 'nullable',
        'APL_Email' => 'required|email|unique:applications',
        'APL_Marital' => 'required',
        'APL_NID' => 'required',
        'APL_NID_Number' => 'required',
        'APL_BPN' => 'required|unique:applications',
        'APL_HLOE' => 'required',
        'APL_HLOE_Other' => 'nullable',
        'APL_Has_Minimum_OLevel_Passes' => 'required',
        'APL_Has_Technical_Qualifications' => 'required',
        'APL_Has_Training' => 'required',
        'APL_Is_Enrolled_In_Training' => 'required',
        'APL_Is_Enrolled_In_YAHP' => 'required',
        'APL_Income' => 'required',
        'APL_Has_Dependant' => 'required',
        'APL_Employment_Status' => 'required',
        'APL_Employment_Status_Other' => 'nullable',
        'APL_Housing_Status' => 'required',
        'APL_Living_Status' => 'required',
        'APL_Owns_Property' => 'required',
        'APL_Family_Owns_Land' => 'required',
        'APL_Is_Interested' => 'required',
        'APL_Interest_Details' => 'required',
        'APL_Expectation' => 'required',
        'APL_Justification' => 'required',
        'APL_Has_Obligations' => 'required',
        'APL_Obligations_Details' => 'nullable',
        'APL_Can_Attend' => 'required',
        'APL_Is_First_Application' => 'required',
        'APL_Source' => 'required',
        'APL_Source_Other' => 'nullable',
        'APL_Emergency_FName' => 'required',
        'APL_Emergency_LName' => 'required',
        'APL_Emergency_Address1' => 'required',
        'APL_Emergency_Address2' => 'required',
        'APL_Emergency_Address3' => 'required',
        'APL_Emergency_Phone' => 'required',
        'APL_Emergency_Relation' => 'required',
        'APL_Recommender_FName' => 'required',
        'APL_Recommender_LName' => 'required',
        'APL_Recommender_Address1' => 'required',
        'APL_Recommender_Address2' => 'required',
        'APL_Recommender_Address3' => 'required',
        'APL_Recommender_Designation' => 'required',
        'APL_Recommender_Phone' => 'required',
        'APL_Can_Use_Photo' => 'required',
        'APL_Can_Subscribe' => 'required',
        'APL_Character_Selection' => 'nullable',
        'APL_Accepts' => 'required|regex:/^Y/',
        'File_Character_Certificate' => 'nullable|file',
        'APL_CRN' => 'nullable',
        'File_Recommender_Statement' => 'required|file',
        'File_Birth_Certificate' => 'required|file',
        'File_National_ID' => 'required|file',
        'Files_Academic_Certificates' => 'nullable|array',
        'Texts_Links' => 'nullable|array',
    ];

    public function createUpload($file, $aplID, $fileName, $description){
        $fileName = str_replace(' ', '_', $fileName);
        $fileName = rand(100,999) . "-{$fileName}";

        $filePath = $file->storeAs($aplID, $fileName);

        Upload::create([
            'UPD_APL_ID' => $aplID,
            'UPD_DocName' => $fileName,
            'UPD_Desc' => $description,
            'UPD_FilePath' => $filePath,
        ]);
    }

    public function uploadAllFiles($aplID, $files){        
        foreach($files as $upload){
            if ($upload['file'] != null){
                if (gettype($upload['file']) == 'array'){
                    foreach($upload['file'] as $file){
                        $this->createUpload(
                            $file, 
                            $aplID, 
                            $file->getClientOriginalName(),
                            $upload['description']
                        );
                    }
                }
                else{
                    $this->createUpload(
                        $upload['file'], 
                        $aplID, 
                        $upload['file']->getClientOriginalName(),
                        $upload['description']
                    );
                }
            }
        };
    }

    public function uploadAllLinks($aplID, $links){
        foreach($links as $link){
            if($link != null){
                Link::create([
                    'NME_ID' => $aplID,
                    'LNK_Link' => $link,
                ]);
            }
        }
    }
    
    public function apply(Request $request){

        // Validate Data
        $validator = Validator::make($request->all(), $this->validatorRules);
                
        // Return with errors upon failure
        if ($validator->fails()) {
            Log::error($validator->errors());
            return redirect(route('application.view'))->withInput($request->all())->withErrors($validator);
        }

        // If a step in the DB transaction fails, the models saved will be rolled back (removed) from the database
        DB::beginTransaction();

        try{
            $validated = $validator->validated();
            
            try{
                $application = Application::create($validated);
            } catch(Exception $e){
                Log::error($e);
                throw new Exception("Error occurred while creating the application form.");
            }
            
            $applicantID = $application->APL_ID;

            try{
                $this->uploadAllFiles(
                    $applicantID, [
                        ['file' => $validated['File_Character_Certificate'] ?? null, 'description' => 'character-certificate'],
                        ['file' => $validated['File_Recommender_Statement'] ?? null, 'description' => 'recommender-statement'],
                        ['file' => $validated['File_Birth_Certificate'] ?? null, 'description' => 'birth-certificate'],
                        ['file' => $validated['File_National_ID'] ?? null, 'description' => 'id-card'],
                        ['file' => $validated['Files_Academic_Certificates'] ?? null, 'description' => 'academic-certificates'],
                ]);
            } catch(Exception $e){
                Log::error($e);
                throw new Exception("Error occurred while uploading files.");
            }
    
            // Upload the links
            try{
                $this->uploadAllLinks($applicantID, $validated['Texts_Links']);
            } catch(Exception $e){
                Log::error($e);
                throw new Exception("Error occurred while saving the supporting links.");
            }
    
            DB::commit();
            
            // Send Mail
            $name = "{$application->APL_FName} {$application->APL_LName}";
            Http::withHeaders([
                'appID' => env('SWIFT_APP_ID'), 
                'Authorization' => 'Bearer ' . env('SWIFT_TOKEN'), 
            ])->post('https://swift.mydns.gov.tt/api/general', [
                'email' => $application->APL_Email,
                'title' => 'Youth Agriculture Homestead Programme 2024 Management System',
                'subject' => 'Youth Agriculture Homestead Programme 2024 APPLICATION',
                'name' => $name,
                'body' => 'This email serves to inform you that your application for The Youth Agricultural Homestead Programme 2024 (YAHP) has been received.',
                'app' => 'YAHP 2024',
                'header' => "Thank you {$name}",
                'fromAddress' => 'yahpinfo.mydns@gov.tt',
                'fromName' => 'MYDNS',
            ]);
    
            return redirect("https://mydns.gov.tt/thank-you/?FirstName={$name}&ProgrammeName=YOUTH%20AGRICULTURAL%20HOMESTEAD%20PROGRAMME%202024%20");
        } catch (Exception $e){
            DB::rollBack();
            return redirect(route('application.view'))->withInput($request->all())->with('submissionError', "There was an error in submission. {$e->getMessage()}");
        }
    }
}