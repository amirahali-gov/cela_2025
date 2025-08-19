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

        // Personal Information
        'APL_FName' => 'required|string|max:255',
        'APL_MName' => 'nullable|string|max:255',
        'APL_LName' => 'required|string|max:255',
        'APL_Address_1' => 'required|string|max:255',
        'APL_Address_2' => 'required|string|max:255',
        'APL_Area' => 'required|string',
        'APL_Gender' => 'required|string',
        'APL_DOB' => 'required|date',
        'APL_PPhone' => 'required|string|max:20',
        'APL_APhone' => 'nullable|string|max:20',
        'APL_Email' => 'required|email|max:255',
        'APL_TT' => 'required|string',
        
        // Identification
        'APL_ID_TYP' => 'required|string',
        'APL_ID_Number' => 'required|string|max:50',
        'APL_BIRTH_PIN' => 'required|string|max:50',
        'APL_Has_NIS' => 'required|string|max:1',
        'APL_NIS_Number' => 'required_if:APL_Has_NIS,Y|string|max:50',
        
        // Banking Information
        // 'APL_BANK_Name' => 'required_if:APL_Has_Bank_Account,Y|string|max:255',
        // 'APL_BANK_Other' => 'required_if:APL_BANK,Other|string|max:255',
        // 'APL_BANK_ACC' => 'required_if:APL_Has_Bank_Account,Y|string|max:50',
        'APL_Has_Bank_Account' => 'required|string|max:1',
        
        // Location/Service
        'APL_Preferred_Region' => 'required|string',
        
        // Education and Qualifications
        'APL_HLOE' => 'required|string',
        'APL_HLOE_Specify' => 'required_if:APL_HLOE,Technical/Vocational|string|max:100',
        'APL_2_CXC_Passes' => 'required|string|max:1',
        'APL_Geriatric_Certif' => 'required|string|max:1',
        'APL_Certification_Institution' => 'required_if:APL_Geriatric_Certif,Y|string|max:255',
        
        // Employment
        'APL_Employment_Status' => 'required|string|max:1',
        'APL_Job_Title' => 'required_if:APL_Employment_Status,1|string|max:255',
        'APL_Employment_Type' => 'required_if:APL_Employment_Status,1|string',
        
        // Availability and Experience
        'APL_Available_Weekdays' => 'required|string',
        'APL_Experience' => 'required|string|max:1000',
        
        // Training and Motivation
        'APL_Motivation_Expectations' => 'required|string|max:1000',
        'APL_Post_Training_Intent' => 'required|string',
        'APL_Post_Training_Other' => 'required_if:APL_Post_Training_Intent,Other|string|max:500',
        
        // Consent and Communication
        'APL_Consent_Followup' => 'required|string',
        'APL_How_Found_Programme' => 'required|string',
        'APL_How_Found_Other' => 'required_if:APL_How_Found_Programme,Other|string|max:100',
        'APL_Subscribe_Mailing' => 'required|string',
        'APL_Photo_Consent' => 'required|string',
        
        // References
        'APL_Prof_Rec_FName' => 'required|string|max:255',
        'APL_Prof_Rec_LName' => 'required|string|max:255',
        'APL_Prof_Rec_Designation' => 'required|string|max:255',
        'APL_Prof_Rec_Phone' => 'required|string|max:20',
        'APL_Prof_Rec_2_FName' => 'required|string|max:255',
        'APL_Prof_Rec_2_LName' => 'required|string|max:255',
        'APL_Prof_Rec_2_Designation' => 'required|string|max:255',
        'APL_Prof_Rec_2_Phone' => 'required|string|max:20',
        
        // Character and Documentation
        'APL_Character_Selection' => 'required|string',
        'APL_CRN' => 'required_if:APL_Character_Selection,Receipt|string|max:100',
        'File_Character_Certificate' => 'required_if:APL_Character_Selection,Certificate|file|mimes:pdf,jpg,jpeg,png|max:5120',
        
        // File uploads
        'File_Birth_Certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_National_ID' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Proof_Address' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Authorization_Letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Owner_ID' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Utility_Bill' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'File_Geriatric_Certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'Files_Academic_Certificates' => 'nullable|array|min:1',
        'Files_Academic_Certificates.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
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

    public function createUpload(UploadedFile $file, int $aplID, string $originalName, string $description)
    {
        // Sanitize filename
        $fileNameClean = str_replace(' ', '_', $originalName);
        $random = rand(100, 999);
        $timestamp = Carbon::now()->format('His'); // HourMinuteSecond for uniqueness
        $finalFileName = "{$random}-{$fileNameClean}";

        // Store file in storage/app/{id}/
        $storagePath = Storage::putFileAs("{$aplID}", $file, $finalFileName);

        // Save upload record
        Upload::create([
            'UPD_APL_ID' => $aplID,
            'UPD_DocName' => $finalFileName,
            'UPD_Desc' => $description,
            'UPD_FilePath' => $storagePath,
        ]);
    }

    public function uploadAllFiles(int $aplID, array $files)
    {
        foreach ($files as $upload) {
            if (!empty($upload['file'])) {
                // If multiple files (array), iterate
                if (is_array($upload['file'])) {
                    foreach ($upload['file'] as $file) {
                        if ($file instanceof UploadedFile) {
                            $this->createUpload($file, $aplID, $file->getClientOriginalName(), $upload['description']);
                        }
                    }
                } elseif ($upload['file'] instanceof UploadedFile) {
                    // Single file
                    $this->createUpload($upload['file'], $aplID, $upload['file']->getClientOriginalName(), $upload['description']);
                }
            }
        }
    }

     public function destroy($inputId, $filename)
    {
        // Find the upload record
        $upload = Upload::where('UPD_DocName', $filename)->first();
        if (!$upload) {
            return response()->json(['success' => false], 404);
        }

        // Delete file from storage
        if (Storage::exists($upload->UPD_FilePath)) {
            Storage::delete($upload->UPD_FilePath);
        }

        // Delete record from database
        $upload->delete();

        return response()->json(['success' => true], 200);
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
        dd($request->all());

        $validator = Validator::make($request->all(), $this->validatorRules, [], $this->getAttributeNames());
        
        $textsLinks = json_decode($request->input('Texts_Links'), true);

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

                $application->save();
                

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
                dd($request->all());
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