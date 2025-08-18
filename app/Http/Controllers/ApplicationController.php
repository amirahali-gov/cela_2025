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

    public function test(Request $request){
        dd("$request->all()");
    }
    
    private $validatorRules = [
        // Administrative fields (usually handled internally)
        'APL_Dup' => 'nullable|boolean',
        'APL_DupUser' => 'nullable|string',
        'APL_Cycle' => 'nullable|string',
        'APL_Invalid' => 'nullable|boolean',
        'APL_Judged' => 'nullable|boolean',
        'APL_Scored' => 'nullable|boolean',
        'APL_Group_Num' => 'nullable|integer',
        'APL_Sort_Num' => 'nullable|integer',
        'APL_ShortList' => 'nullable|boolean',
        
        // Personal Information
        'APL_FName' => 'required|string|max:255',
        'APL_LName' => 'required|string|max:255',
        'APL_MName' => 'nullable|string|max:255',
        'APL_Address_1' => 'required|string|max:255',
        'APL_Address_2' => 'nullable|string|max:255',
        'APL_Address_3' => 'nullable|string|max:255',
        'APL_Area' => 'required|string',
        'APL_Gender' => 'required|string',
        'APL_DOB' => 'required|date',
        'APL_Age' => 'required|integer|min:1|max:120',
        'APL_PPhone' => 'required|string|max:20',
        'APL_APhone' => 'nullable|string|max:20',
        'APL_Email' => 'required|email|max:255',
        'APL_Marital' => 'required|string',
        'APL_TT' => 'nullable|string',
        
        // Identification
        'APL_NID' => 'required|string',
        'APL_NID_Number' => 'required|string|max:50',
        'APL_ID_TYP' => 'nullable|string',
        'APL_ID_Number' => 'nullable|string|max:50',
        'APL_BPN' => 'required|string|max:50',
        'APL_BIRTH_PIN' => 'nullable|string|max:50',
        'APL_Has_NIS' => 'nullable|boolean',
        'APL_NIS_Number' => 'nullable|string|max:50',
        
        // Banking Information
        'APL_BANK' => 'nullable|string',
        'APL_BANK_Name' => 'nullable|string|max:255',
        'APL_BANK_Other' => 'nullable|string|max:255',
        'APL_BANK_ACC' => 'nullable|string|max:50',
        'APL_Has_Bank_Account' => 'nullable|boolean',
        
        // Location/Service
        'APL_Service_Area' => 'nullable|string',
        'APL_Preferred_Region' => 'nullable|string',
        
        // Education and Qualifications
        'APL_HLOE' => 'required|string',
        'APL_HLOE_Other' => 'nullable|string|max:500',
        'APL_HLOE_Specify' => 'nullable|string|max:500',
        'APL_2_CXC_Passes' => 'nullable|boolean',
        'APL_Geriatric_Certif' => 'nullable|boolean',
        'APL_Graduate' => 'nullable|boolean',
        'APL_Certification_Institution' => 'nullable|string|max:255',
        
        // Employment
        'APL_Employment_Status' => 'required|string',
        'APL_Employment_Status_Other' => 'nullable|string|max:500',
        'APL_Job_Title' => 'nullable|string|max:255',
        'APL_Employment_Type' => 'nullable|string',
        'APL_Field' => 'nullable|string|max:255',
        
        // Availability and Experience
        'APL_Available_Weekdays' => 'nullable|string',
        'APL_Available_GAPP' => 'nullable|string',
        'APL_Availability_Weekdays' => 'required|string',
        'APL_Availability_Weekends' => 'required|string',
        'APL_Experience' => 'nullable|string',
        'APL_Previous_Geriatric_Experience' => 'required|string',
        'APL_Geriatric_Experience_Details' => 'nullable|string|max:1000',
        
        // Training and Motivation
        'APL_Training_Expectations' => 'required|string|max:1000',
        'APL_Motivation_Expectations' => 'nullable|string|max:1000',
        'APL_Interest_Details' => 'required|string|max:1000',
        'APL_Post_Training_Intent' => 'required|string',
        'APL_Post_Training_Other' => 'nullable|string|max:500',
        
        // Organization Membership
        'APL_Youth_Group_Member' => 'required|string',
        'APL_Organization_Name' => 'nullable|string|max:255',
        'APL_Role' => 'nullable|string|max:255',
        'APL_Membership_Length' => 'nullable|string|max:100',
        
        // Transport and Logistics
        'APL_Transport_Mode' => 'required|string',
        'APL_Transport_Mode_Other' => 'nullable|string|max:255',
        
        // Consent and Communication
        'APL_Consent_Followup' => 'required|string',
        'APL_How_Found_Programme' => 'required|string',
        'APL_How_Found_Other' => 'nullable|string|max:500',
        'APL_Subscribe_Mailing' => 'required|string',
        'APL_Photo_Consent' => 'required|string',
        
        // References
        'APL_Prof_Rec_FName' => 'required|string|max:255',
        'APL_Prof_Rec_LName' => 'nullable|string|max:255',
        'APL_Prof_Rec_Designation' => 'required|string|max:255',
        'APL_Prof_Rec_Phone' => 'required|string|max:20',
        'APL_Prof_Rec_2_FName' => 'required|string|max:255',
        'APL_Prof_Rec_2_Designation' => 'required|string|max:255',
        'APL_Prof_Rec_2_Phone' => 'required|string|max:20',
        'APL_Pers_Rec_FName' => 'nullable|string|max:255',
        'APL_Pers_Rec_LName' => 'nullable|string|max:255',
        'APL_Pers_Rec_Phone' => 'nullable|string|max:20',
        'APL_Pers_Rec_Relationship' => 'nullable|string|max:255',
        
        // Character and Documentation
        'APL_Character_Selection' => 'required|string',
        'APL_CRN' => 'nullable|string|max:100',
        
        // File uploads
        'File_Birth_Certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_National_ID' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Proof_Address' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Authorization_Letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Owner_ID' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Utility_Bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Geriatric_Certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'Files_Academic_Certificates' => 'required|array|min:1',
        'Files_Academic_Certificates.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Character_Certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Recommender_Statement_1' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Recommender_Statement_2' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_NIS_Card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        
        // Final acceptance
        'APL_Accepts' => 'required|in:Y'
    ];

    private function getAttributeNames()
    {
        return [
            // Administrative fields
            'APL_Dup' => 'Duplicate Application',
            'APL_DupUser' => 'Duplicate User',
            'APL_Cycle' => 'Application Cycle',
            'APL_Invalid' => 'Invalid Application',
            'APL_Judged' => 'Judged Status',
            'APL_Scored' => 'Scored Status',
            'APL_Group_Num' => 'Group Number',
            'APL_Sort_Num' => 'Sort Number',
            'APL_ShortList' => 'Shortlist Status',
            
            // Personal Information
            'APL_FName' => 'First Name',
            'APL_LName' => 'Last Name',
            'APL_MName' => 'Middle Name',
            'APL_Address_1' => 'Address Line 1',
            'APL_Address_2' => 'Address Line 2',
            'APL_Address_3' => 'Address Line 3',
            'APL_Area' => 'Area/Region',
            'APL_Gender' => 'Gender',
            'APL_DOB' => 'Date of Birth',
            'APL_Age' => 'Age',
            'APL_PPhone' => 'Primary Phone',
            'APL_APhone' => 'Alternate Phone',
            'APL_Email' => 'Email Address',
            'APL_Marital' => 'Marital Status',
            'APL_TT' => 'Trinidad and Tobago Resident',
            
            // Identification
            'APL_NID' => 'National ID Type',
            'APL_NID_Number' => 'National ID Number',
            'APL_ID_TYP' => 'ID Type',
            'APL_ID_Number' => 'ID Number',
            'APL_BPN' => 'Birth Pin Number',
            'APL_BIRTH_PIN' => 'Birth Pin',
            'APL_Has_NIS' => 'Has NIS Number',
            'APL_NIS_Number' => 'NIS Number',
            
            // Banking Information
            'APL_BANK' => 'Bank',
            'APL_BANK_Name' => 'Bank Name',
            'APL_BANK_Other' => 'Other Bank',
            'APL_BANK_ACC' => 'Bank Account Number',
            'APL_Has_Bank_Account' => 'Has Bank Account',
            
            // Location/Service
            'APL_Service_Area' => 'Service Area',
            'APL_Preferred_Region' => 'Preferred Region',
            
            // Education and Qualifications
            'APL_HLOE' => 'Highest Level of Education',
            'APL_HLOE_Other' => 'Other Education Details',
            'APL_HLOE_Specify' => 'Education Specification',
            'APL_2_CXC_Passes' => 'Has 2 CXC Passes',
            'APL_Geriatric_Certif' => 'Geriatric Certificate',
            'APL_Graduate' => 'Graduate Status',
            'APL_Certification_Institution' => 'Certification Institution',
            
            // Employment
            'APL_Employment_Status' => 'Employment Status',
            'APL_Employment_Status_Other' => 'Other Employment Status',
            'APL_Job_Title' => 'Job Title',
            'APL_Employment_Type' => 'Employment Type',
            'APL_Field' => 'Field of Work',
            
            // Availability and Experience
            'APL_Available_Weekdays' => 'Available Weekdays',
            'APL_Available_GAPP' => 'Available for GAPP',
            'APL_Availability_Weekdays' => 'Weekday Availability',
            'APL_Availability_Weekends' => 'Weekend Availability',
            'APL_Experience' => 'Experience',
            'APL_Previous_Geriatric_Experience' => 'Previous Geriatric Experience',
            'APL_Geriatric_Experience_Details' => 'Geriatric Experience Details',
            
            // Training and Motivation
            'APL_Training_Expectations' => 'Training Expectations',
            'APL_Motivation_Expectations' => 'Motivation and Expectations',
            'APL_Interest_Details' => 'Interest Details',
            'APL_Post_Training_Intent' => 'Post Training Intent',
            'APL_Post_Training_Other' => 'Other Post Training Plans',
            
            // Organization Membership
            'APL_Youth_Group_Member' => 'Youth Group Membership',
            'APL_Organization_Name' => 'Organization Name',
            'APL_Role' => 'Role in Organization',
            'APL_Membership_Length' => 'Membership Length',
            
            // Transport and Logistics
            'APL_Transport_Mode' => 'Transport Mode',
            'APL_Transport_Mode_Other' => 'Other Transport Mode',
            
            // Consent and Communication
            'APL_Consent_Followup' => 'Consent for Follow-up',
            'APL_How_Found_Programme' => 'How Found Programme',
            'APL_How_Found_Other' => 'Other Source Details',
            'APL_Subscribe_Mailing' => 'Subscribe to Mailing List',
            'APL_Photo_Consent' => 'Photo Consent',
            
            // References
            'APL_Prof_Rec_FName' => 'Professional Reference First Name',
            'APL_Prof_Rec_LName' => 'Professional Reference Last Name',
            'APL_Prof_Rec_Designation' => 'Professional Reference Designation',
            'APL_Prof_Rec_Phone' => 'Professional Reference Phone',
            'APL_Prof_Rec_2_FName' => 'Second Professional Reference First Name',
            'APL_Prof_Rec_2_Designation' => 'Second Professional Reference Designation',
            'APL_Prof_Rec_2_Phone' => 'Second Professional Reference Phone',
            'APL_Pers_Rec_FName' => 'Personal Reference First Name',
            'APL_Pers_Rec_LName' => 'Personal Reference Last Name',
            'APL_Pers_Rec_Phone' => 'Personal Reference Phone',
            'APL_Pers_Rec_Relationship' => 'Personal Reference Relationship',
            
            // Character and Documentation
            'APL_Character_Selection' => 'Character Certificate Selection',
            'APL_CRN' => 'Certificate Receipt Number',
            
            // File uploads
            'File_Birth_Certificate' => 'Birth Certificate',
            'File_National_ID' => 'National ID',
            'File_Proof_Address' => 'Proof of Address',
            'File_Authorization_Letter' => 'Authorization Letter',
            'File_Owner_ID' => 'Property Owner ID',
            'File_Utility_Bill' => 'Utility Bill',
            'File_Geriatric_Certificate' => 'Geriatric Certificate',
            'Files_Academic_Certificates' => 'Academic Certificates',
            'File_Character_Certificate' => 'Character Certificate',
            'File_Recommender_Statement_1' => 'First Recommender Statement',
            'File_Recommender_Statement_2' => 'Second Recommender Statement',
            'File_NIS_Card' => 'NIS Card',
            
            // Supporting content
            'Texts_Links' => 'Supporting Links',
            
            // Final acceptance
            'APL_Accepts' => 'Acceptance of Terms',
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

        $validator = Validator::make($request->all(), $this->validatorRules, [], $this->getAttributeNames());

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
                
                // Filter out file fields from validated data as they are handled separately
                $excludeFields = [
                    'File_Birth_Certificate',
                    'File_National_ID',
                    'File_Proof_Address',
                    'File_Authorization_Letter',
                    'File_Owner_ID',
                    'File_Utility_Bill',
                    'File_Geriatric_Certificate',
                    'Files_Academic_Certificates',
                    'File_Character_Certificate',
                    'File_Recommender_Statement_1',
                    'File_Recommender_Statement_2',
                    'File_NIS_Card'
                ];
                
                // Populate application with validated data (excluding file fields)
                foreach ($validated as $field => $value) {
                    if (!in_array($field, $excludeFields) && in_array($field, $application->getFillable())) {
                        $application->$field = $value;
                    }
                }

                dd($application);
                // $application->save();
                

            } catch(Exception $e){
                Log::error($e);
                throw new Exception("Error occurred while creating the application form.");
            }
            
            $applicantID = $application->APL_ID;

            try{
                $this->uploadAllFiles(
                    $applicantID, [
                        ['file' => $validated['File_Birth_Certificate'] ?? null, 'description' => 'birth-certificate'],
                        ['file' => $validated['File_National_ID'] ?? null, 'description' => 'id-card'],
                        ['file' => $validated['File_Proof_Address'] ?? null, 'description' => 'proof-of-address'],
                        ['file' => $validated['File_Authorization_Letter'] ?? null, 'description' => 'authorization-letter'],
                        ['file' => $validated['File_Owner_ID'] ?? null, 'description' => 'owner-id'],
                        ['file' => $validated['File_Utility_Bill'] ?? null, 'description' => 'utility-bill'],
                        ['file' => $validated['File_Geriatric_Certificate'] ?? null, 'description' => 'geriatric-certificate'],
                        ['file' => $validated['Files_Academic_Certificates'] ?? null, 'description' => 'academic-certificates'],
                        ['file' => $validated['File_Character_Certificate'] ?? null, 'description' => 'character-certificate'],
                        ['file' => $validated['File_Recommender_Statement_1'] ?? null, 'description' => 'recommender-statement-1'],
                        ['file' => $validated['File_Recommender_Statement_2'] ?? null, 'description' => 'recommender-statement-2'],
                        ['file' => $validated['File_NIS_Card'] ?? null, 'description' => 'nis-card'],
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
                'title' => 'Geriatric Adolescent Partnership Programme 2025 Management System',
                'subject' => 'Geriatric Adolescent Partnership Programme 2025 APPLICATION',
                'name' => $name,
                'body' => 'This email serves to inform you that your application for The Geriatric Adolescent Partnership Programme 2025 has been received.',
                'app' => 'GAPP 2025',
                'header' => "Thank you {$name}",
                'fromAddress' => 'youthinfo.mydns@gov.tt',
                'fromName' => 'MYDNS',
            ]);
    
            return redirect("https://mydns.gov.tt/thank-you/?FirstName={$name}&ProgrammeName=GERIATRIC%20ADOLESCENT%20PARTNERSHIP%20PROGRAMME%202025%20");
        } catch (Exception $e){
            DB::rollBack();
            return redirect(route('application.view'))->withInput($request->all())->with('submissionError', "There was an error in submission. {$e->getMessage()}");
        }
    }
}