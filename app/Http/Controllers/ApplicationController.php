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
        'APL_LName' => 'required',
        'APL_Title' => 'required',
        'APL_Address1' => 'required',
        'APL_Address2' => 'required',
        'APL_Address3' => 'required',
        'APL_Municipality' => 'required',
        'APL_Gender' => 'required',
        'APL_DOB' => 'required|date',
        'APL_PPhone' => 'required',
        'APL_APhone' => 'nullable',
        'APL_Email' => 'required|email|unique:applications',
        'APL_Marital' => 'required',
        'APL_NID' => 'required',
        'APL_NID_Number' => 'required',
        'APL_BPN' => 'required|unique:applications',
        'APL_HLOE' => 'required',
        'APL_HLOE_Other' => 'nullable',
        'APL_Employment_Status' => 'required',
        'APL_Employment_Status_Other' => 'nullable',
        'APL_Field' => 'nullable',
        'APL_Accommodation' => 'required',
        'APL_Accommodation_Details' => 'nullable|required_if:APL_Accommodation,Yes',
        'APL_Interest_Details' => 'required',
        'APL_Youth_Group_Member' => 'required',
        'APL_Organization_Name' => 'nullable|required_if:APL_Youth_Group_Member,Yes',
        'APL_Role' => 'nullable|required_if:APL_Youth_Group_Member,Yes',
        'APL_Membership_Length' => 'nullable|required_if:APL_Youth_Group_Member,Yes',
        'APL_Availability_Virtual' => 'required',
        'APL_Availability_InPerson' => 'required',
        'APL_Internet' => 'required',
        'APL_Obligations' => 'required',
        'APL_Obligations_Details' => 'nullable|required_if:APL_Obligations,Yes',
        'APL_MYDNS_Participant' => 'required',
        'APL_MYDNS_Participant_Details' => 'nullable|required_if:APL_MYDNS_Participant,Yes',
        'APL_NS_Interest' => 'required',
        'APL_Expectations' => 'required',
        'APL_NoK_Name' => 'required',
        'APL_NoK_Contact' => 'required',
        'APL_PG_Name' => 'nullable',
        'APL_PG_Contact' => 'nullable',
        'APL_COC_Choice' => 'required',
        'File_Character_Certificate' => 'nullable|required_if:APL_COC_Choice,COC|file|mimes:pdf,jpg,png',
        'APL_CRN' => 'nullable|required_if:APL_COC_Choice,CRN',
        'File_Character_Certificate' => 'nullable|required_if:APL_COC_Choice,COC|file|mimes:pdf,jpg,png|max:2048', // 2MB limit
        'File_Recommender_Statement' => 'required|file|mimes:pdf,jpg,png|max:2048', 
        'File_Birth_Certificate' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'File_National_ID' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'Files_Academic_Certificates' => 'nullable|array',
        'Files_Academic_Certificates.*' => 'file|mimes:pdf,jpg,png|max:2048',
        'Texts_Links' => 'nullable',
        'APL_Accepts' => 'required|in:Y',
    ];

    private function getAttributeNames()
    {
        return [
            'APL_FName' => 'First Name',
            'APL_LName' => 'Last Name',
            'APL_Title' => 'Title',
            'APL_Address1' => 'Address Line 1',
            'APL_Address2' => 'Address Line 2',
            'APL_Address3' => 'Address Line 3',
            'APL_Municipality' => 'Municipality',
            'APL_Gender' => 'Gender',
            'APL_DOB' => 'Date of Birth',
            'APL_PPhone' => 'Primary Phone',
            'APL_APhone' => 'Alternate Phone',
            'APL_Email' => 'Email Address',
            'APL_Marital' => 'Marital Status',
            'APL_NID' => 'National ID Type',
            'APL_NID_Number' => 'National ID Number',
            'APL_BPN' => 'Birth Pin Number',
            'APL_HLOE' => 'Highest Level of Education',
            'APL_Employment_Status' => 'Employment Status',
            'APL_Field' => 'Field of Work',
            'APL_Accommodation' => 'Accommodation Requirements',
            'APL_Accommodation_Details' => 'Accommodation Details',
            'APL_Interest_Details' => 'Interest Details',
            'APL_Youth_Group_Member' => 'Youth Group Membership',
            'APL_Organization_Name' => 'Organization Name',
            'APL_Role' => 'Role in Organization',
            'APL_Membership_Length' => 'Membership Length',
            'APL_Availability_Virtual' => 'Availability for Virtual Sessions',
            'APL_Availability_InPerson' => 'Availability for In-Person Sessions',
            'APL_Internet' => 'Internet Access',
            'APL_Obligations' => 'Existing Obligations',
            'APL_Obligations_Details' => 'Obligation Details',
            'APL_MYDNS_Participant' => 'MYDNS Participant',
            'APL_MYDNS_Participant_Details' => 'MYDNS Participant Details',
            'APL_NS_Interest' => 'National Service and Volunteerism Interest',
            'APL_Expectations' => 'Expectations',
            'APL_NoK_Name' => 'Next of Kin Name',
            'APL_NoK_Contact' => 'Next of Kin Contact',
            'APL_COC_Choice' => 'Choice of Certification',
            // 'File_Character_Certificate' => 'Character Certificate',
            // 'File_Recommender_Statement' => 'Recommender Statement',
            // 'File_Birth_Certificate' => 'Birth Certificate',
            // 'File_National_ID' => 'National ID',
            // 'Texts_Links' => 'Supporting Links',
            // 'APL_Accepts' => 'Acceptance of Terms',
        ];
    }

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

        $validator = Validator::make($request->all(), $this->validatorRules);
        $validator->setAttributeNames($this->getAttributeNames());

        $textsLinks = json_decode($request->input('Texts_Links'), true);

        // return $request;

        if ($validator->fails()) {
            Log::error($validator->errors());
            return redirect(route('application.view'))->withInput($request->all())->withErrors($validator);
            
            /**Store uploaded files temporarily
             
            $uploadedFiles = [];

            $fileKeys = [
                'File_Character_Certificate', 
                'File_Recommender_Statement', 
                'File_Birth_Certificate', 
                'File_National_ID',
                'Files_Academic_Certificates' // This is an array of files
            ];
            
            foreach ($fileKeys as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    if (is_array($request->file($fileKey))) {
                        // Handle multiple file uploads
                        foreach ($request->file($fileKey) as $file) {
                            $path = $file->store('public/temp'); // Save to temp storage
                            $uploadedFiles[$fileKey][] = $path; // Store path
                        }
                    } else {
                        // Handle single file uploads
                        $file = $request->file($fileKey);
                        $path = $file->store('public/temp'); 
                        $uploadedFiles[$fileKey] = $path;
                    }
                }
            }
            
            return redirect(route('application.view'))
            ->withInput($request->except(array_keys($fileKeys))) // Keep form data except files
            ->with('uploadedFiles', $uploadedFiles) // Store uploaded files in session
            ->withErrors($validator);
             */
        }

        // If a step in the DB transaction fails, the models saved will be rolled back (removed) from the database
        DB::beginTransaction();

        try{
            
            $validated = $validator->validated();
            
            
            
            try{
                $application = new Application();
                
                $application->APL_FName = $validated['APL_FName'];
                $application->APL_LName = $validated['APL_LName'];
                $application->APL_Title = $validated['APL_Title'];
                $application->APL_Address1 = $validated['APL_Address1'];
                $application->APL_Address2 = $validated['APL_Address2'];
                $application->APL_Address3 = $validated['APL_Address3'];
                $application->APL_Municipality = $validated['APL_Municipality'];
                $application->APL_Gender = $validated['APL_Gender'];
                $application->APL_DOB = $validated['APL_DOB'];
                $application->APL_PPhone = $validated['APL_PPhone'];
                $application->APL_APhone = $validated['APL_APhone'];
                $application->APL_Email = $validated['APL_Email'];
                $application->APL_Marital = $validated['APL_Marital'];
                $application->APL_NID = $validated['APL_NID'];
                $application->APL_NID_Number = $validated['APL_NID_Number'];
                $application->APL_BPN = $validated['APL_BPN'];
                $application->APL_HLOE = $validated['APL_HLOE'];
                $application->APL_HLOE_Other = $validated['APL_HLOE_Other'];
                $application->APL_Employment_Status = $validated['APL_Employment_Status'];
                $application->APL_Employment_Status_Other = $validated['APL_Employment_Status_Other'];
                $application->APL_Field = $validated['APL_Field'];
                $application->APL_Accommodation = $validated['APL_Accommodation'];
                $application->APL_Accommodation_Details = $validated['APL_Accommodation_Details'] ?? null;
                $application->APL_Interest_Details = $validated['APL_Interest_Details'];
                $application->APL_Youth_Group_Member = $validated['APL_Youth_Group_Member'];
                $application->APL_Organization_Name = $validated['APL_Organization_Name'] ?? null;
                $application->APL_Role = $validated['APL_Role'] ?? null;
                $application->APL_Membership_Length = $validated['APL_Membership_Length'] ?? null;
                $application->APL_Availability_Virtual = $validated['APL_Availability_Virtual'];
                $application->APL_Availability_InPerson = $validated['APL_Availability_InPerson'];
                $application->APL_Internet = $validated['APL_Internet'];
                $application->APL_Obligations = $validated['APL_Obligations'];
                $application->APL_Obligations_Details = $validated['APL_Obligations_Details'] ?? null;
                $application->APL_MYDNS_Participant = $validated['APL_MYDNS_Participant'];
                $application->APL_MYDNS_Participant_Details = $validated['APL_MYDNS_Participant_Details'] ?? null;
                $application->APL_NS_Interest = $validated['APL_NS_Interest'];
                $application->APL_Expectations = $validated['APL_Expectations'];
                $application->APL_NoK_Name = $validated['APL_NoK_Name'] ?? null;
                $application->APL_NoK_Contact = $validated['APL_NoK_Contact'] ?? null;
                $application->APL_PG_Name = $validated['APL_PG_Name'] ?? null;
                $application->APL_PG_Contact = $validated['APL_PG_Contact'] ?? null;
                $application->APL_COC_Choice = $validated['APL_COC_Choice'];
                $application->APL_CRN = $validated['APL_CRN'] ?? null;
                $application->APL_Accepts = $validated['APL_Accepts'];

                $application->save();
                

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
    
            if (!empty($textsLinks)){
                try{

                    
                    $this->uploadAllLinks($applicantID, $textsLinks);
    
                } catch(Exception $e){
                    Log::error($e);
                    throw new Exception("Error occurred while saving the supporting links.");
                }
            }


    
            DB::commit();
            
            // Send Mail
            $name = "{$application->APL_FName} {$application->APL_LName}";
            Http::withHeaders([
                'appID' => env('SWIFT_APP_ID'), 
                'Authorization' => 'Bearer ' . env('SWIFT_TOKEN'), 
            ])->post('https://swift.mydns.gov.tt/api/general', [
                'email' => $application->APL_Email,
                'title' => 'National Leadership Training Programme 2025 Management System',
                'subject' => 'National Leadership Training Programme 2025 APPLICATION',
                'name' => $name,
                'body' => 'This email serves to inform you that your application for The National Leadership Training Programme 2025 has been received.',
                'app' => 'NLTP 2025',
                'header' => "Thank you {$name}",
                'fromAddress' => 'youthinfo.mydns@gov.tt',
                'fromName' => 'MYDNS',
            ]);
    
            return redirect("https://mydns.gov.tt/thank-you/?FirstName={$name}&ProgrammeName=NATIONAL%20LEADERSHIP%20TRAINING%20PROGRAMME%202025%20");
        } catch (Exception $e){
            DB::rollBack();
            return redirect(route('application.view'))->withInput($request->all())->with('submissionError', "There was an error in submission. {$e->getMessage()}");
        }
    }
}