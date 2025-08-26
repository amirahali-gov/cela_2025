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
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


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
        'APL_Address_3' => 'required|string',
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
        'APL_NIS_Number' => 'required_if:APL_Has_NIS,Y|nullable|string|max:55',
        
        // Banking Information
        // 'APL_BANK_Name' => 'required_if:APL_Has_Bank_Account,Y|string|max:255',
        // 'APL_BANK_Other' => 'required_if:APL_BANK,Other|string|max:255',
        // 'APL_BANK_ACC' => 'required_if:APL_Has_Bank_Account,Y|string|max:50',
        'APL_Has_Bank_Account' => 'required|string|max:1',
        
        // Location/Service
        'APL_Service_Area' => 'required|string',
        
        // Education and Qualifications
        'APL_HLOE' => 'required|string',
        'APL_HLOE_Specify' => 'required_if:APL_HLOE,Technical/Vocational|nullable|string|max:100',
        'APL_2_CXC_Passes' => 'required|string|max:1',
        'APL_Geriatric_Certif' => 'required|string|max:1',
        'APL_Graduate' => 'required_if:APL_Geriatric_Certif,Y|nullable|string|max:255',
        
        // Employment
        'APL_Employment_Status' => 'required|string|max:1',
        'APL_Job_Title' => 'required_if:APL_Employment_Status,Y|nullable|string|max:255',
        'APL_Employment_Type' => 'required_if:APL_Employment_Status,Y|string',
        
        // Availability and Experience
        'APL_Available_Weekdays' => 'required|string',
        'APL_Experience' => 'required|string|max:1000',
        
        // Training and Motivation
        'APL_Motivation_Expectations' => 'required|string|max:1000',
        'APL_Post_Training_Intent' => 'required|string',
        'APL_Post_Training_Other' => 'required_if:APL_Post_Training_Intent,Other|nullable|string|max:500',
        
        // Consent and Communication
        'APL_Consent_Followup' => 'required|string',
        'APL_How_Found_Programme' => 'required|string',
        'APL_How_Found_Other' => 'required_if:APL_How_Found_Programme,Other|nullable|string|max:100',
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
        'APL_Character_Selection' => 'required|string|max:25',
        'APL_CRN' => 'required_if:APL_Character_Selection,CRN|nullable|string|max:20',
        'File_Character_Certificate' => 'required_if:APL_Character_Selection,COC|file',
        
        // File uploads
        // 'File_Birth_Certificate' => 'required|file',
        // 'File_National_ID' => 'required|file',
        // 'File_Proof_Address' => 'required|file',
        // 'File_Authorization_Letter' => 'nullable|file',
        // 'File_Owner_ID' => 'nullable|file',
        // 'File_Geriatric_Certificate' => 'nullable|file',
        // 'Files_Academic_Certificates' => 'nullable|array|min:1',
        // 'Files_Academic_Certificates.*' => 'file',
        // 'File_Recommender_Statement_1' => 'required|file',
        // 'File_Recommender_Statement_2' => 'required|file',
        // 'File_NIS_Card' => 'nullable|file',

        'File_Birth_Certificate' => 'required',
        'File_National_ID' => 'required',
        'File_Proof_Address' => 'required',
        'File_Authorization_Letter' => 'nullable',
        'File_Owner_ID' => 'nullable',
        'File_Geriatric_Certificate' => 'nullable',
        'Files_Academic_Certificates' => 'nullable|array|min:1',
        'Files_Academic_Certificates.*' => 'file',
        'File_Recommender_Statement_1' => 'required',
        'File_Recommender_Statement_2' => 'required',
        'File_NIS_Card' => 'nullable',
        
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
            'APL_Address_3' => 'Area/Region',
            'APL_Area' => 'Area/Region Code',
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
        // Ensure the folder exists in the public disk
        $folder = "{$aplID}";
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
            Log::debug('Created directory ' . $folder);
        }

        // Sanitize filename
        $fileNameClean = str_replace(' ', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();

        // Unique filename: random + timestamp + cleaned name + extension
        $random = rand(100, 999);
        $timestamp = Carbon::now()->format('YmdHis'); // YearMonthDayHourMinuteSecond
        $finalFileName = "{$random}-{$timestamp}-{$fileNameClean}.{$extension}";

        // Store file in storage/app/public/{aplID}/
        $storagePath = $file->storeAs($folder, $finalFileName, 'public');

        // Save upload record with public path
        Upload::create([
            'UPD_APL_ID' => $aplID,
            'UPD_DocName' => $finalFileName,
            'UPD_Desc' => $description,
            'UPD_FilePath' => "storage/{$storagePath}", // public URL path
        ]);
    }

    /**
     * Upload multiple files at once.
     */
    public function uploadAllFiles(int $aplID, array $files)
    {
        foreach ($files as $upload) {
            if (!empty($upload['file'])) {
                // Multiple files
                if (is_array($upload['file'])) {
                    foreach ($upload['file'] as $file) {
                        if ($file instanceof UploadedFile) {
                            $this->createUpload(
                                $file,
                                $aplID,
                                $file->getClientOriginalName(),
                                $upload['description'] ?? ''
                            );
                        }
                    }
                }
                // Single file
                elseif ($upload['file'] instanceof UploadedFile) {
                    $this->createUpload(
                        $upload['file'],
                        $aplID,
                        $upload['file']->getClientOriginalName(),
                        $upload['description'] ?? ''
                    );

                    
                }
            }
        }
    }

    public function destroy($inputId, $filename)
    {
        // Find the upload record
        $upload = Upload::where('UPD_DocName', $filename)->first();
        if (!$upload) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        // Remove "storage/" prefix to get relative path
        $relativePath = str_replace('storage/', '', $upload->UPD_FilePath);

        // Delete file from storage
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        // Delete record from database
        $upload->delete();

        return response()->json(['success' => true], 200);
    }
    

    public function removeSessionFile(Request $request, $inputId, $filename)
    {
        $uploadedFiles = session("uploadedFiles", []);

        if (isset($uploadedFiles[$inputId])) {
            $uploadedFiles[$inputId] = array_filter($uploadedFiles[$inputId], function($file) use ($filename) {
                return $file['name'] !== $filename;
            });

            session()->put('uploadedFiles', $uploadedFiles);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function deleteSessionFile($inputId, $filename)
    {
        if (!session()->has("uploadedFiles.$inputId")) {
            return response()->json(['success' => false, 'message' => 'No files in session'], 404);
        }

        $uploadedFiles = session("uploadedFiles.$inputId");

        // Remove the file matching $filename
        $uploadedFiles = array_filter($uploadedFiles, function($file) use ($filename) {
            return (is_array($file) ? $file['name'] : basename($file)) !== $filename;
        });

        // Re-index array and put back into session
        session()->put("uploadedFiles.$inputId", array_values($uploadedFiles));

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

  
  
  
  
   public function apply(Request $request)
    {
        $fileFields = [
            'File_Birth_Certificate' => 'single',
            'File_National_ID' => 'single',
            'File_Proof_Address' => 'single',
            'File_Authorization_Letter' => 'single',
            'File_Owner_ID' => 'single',
            'File_Geriatric_Certificate' => 'single',
            'Files_Academic_Certificates' => 'multi', // multiple files
            'File_Character_Certificate' => 'single',
            'File_Recommender_Statement_1' => 'single',
            'File_Recommender_Statement_2' => 'single',
            'File_NIS_Card' => 'single',
        ];

        $uploadedFilesSession = session()->get('uploadedFiles', []);
        $allInput = $request->all();


        foreach ($fileFields as $field => $type) {
            if (!$request->hasFile($field) && isset($uploadedFilesSession[$field])) {
                $sessionFile = $uploadedFilesSession[$field];

                if ($type === 'multi') {
                    $allInput[$field] = [];
                    foreach ($sessionFile as $f) {
                        $fullPath = storage_path('app/public/' . $f['path']);
                        if (file_exists($fullPath)) {
                            $allInput[$field][] = new UploadedFile(
                                $fullPath,
                                $f['name'],
                                null,
                                null,
                                true
                            );
                        }
                    }
                } else {
                    $fullPath = storage_path('app/public/' . $sessionFile['path']);
                    if (file_exists($fullPath)) {
                        $allInput[$field] = new UploadedFile(
                            $fullPath,
                            $sessionFile['name'],
                            null,
                            null,
                            true
                        );
                    } else {
                        $allInput[$field] = null; // prevents "must be a file"
                    }
                }
            }
        }

        $validator = Validator::make($allInput, $this->validatorRules, [], $this->getAttributeNames());

        if ($validator->fails()) {
            // Save newly uploaded files to session
            foreach ($fileFields as $field => $type) {
                if ($request->hasFile($field)) {
                    $files = $request->file($field);

                    if ($type === 'multi') {
                        if (!isset($uploadedFilesSession[$field])) {
                            $uploadedFilesSession[$field] = [];
                        }
                        foreach ($files as $file) {
                            $uploadedFilesSession[$field][] = [
                                'path' => $file->store('tmp', 'public'),
                                'name' => $file->getClientOriginalName(),
                            ];
                        }
                    } else {
                        // single file
                        $uploadedFilesSession[$field] = [
                            'path' => $files->store('tmp', 'public'),
                            'name' => $files->getClientOriginalName(),
                        ];
                    }
                }
            }
            session()->put('uploadedFiles', $uploadedFilesSession);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        session()->forget('uploadedFiles');

        DB::beginTransaction();
        try {
            $validated = $validator->validated();

            $application = new Application();
            $excludeFields = array_keys($fileFields);
            foreach ($validated as $field => $value) {
                if (!in_array($field, $excludeFields) && in_array($field, $application->getFillable())) {
                    $application->$field = $value;
                }
            }

            $application->APL_Cycle = 3;
            $application->APL_Area = Area::where('Area_CC', $validated['APL_Address_3'])->value('Board');
            $application->APL_Age = Carbon::parse($validated['APL_DOB'])->age;
            $application->save();
            $applicantID = $application->APL_ID;

            
            $uploadData = [];
            foreach ($fileFields as $field => $type) {
                if (isset($validated[$field])) {
                    $uploadData[] = ['file' => $validated[$field], 'description' => $field];
                }
            }
            $this->uploadAllFiles($applicantID, $uploadData);

  
            $textsLinks = json_decode($request->input('Texts_Links'), true);
            if (!empty($textsLinks)) {
                $this->uploadAllLinks($applicantID, $textsLinks);
            }

            DB::commit();

            $name = "{$application->APL_FName} {$application->APL_LName}";
            Http::withHeaders([
                'appID' => env('SWIFT_APP_ID'), 
                'Authorization' => 'Bearer ' . env('SWIFT_TOKEN'), 
            ])->post('https://swift.msya.gov.tt/api/general', [
                'email' => $application->APL_Email,
                'title' => 'Geriatric Adolescent Partnership Programme 2025 Management System',
                'subject' => 'Geriatric Adolescent Partnership Programme 2025 APPLICATION',
                'name' => $name,
                'body' => 'This email serves to inform you that your application has been received.',
                'app' => 'GAPP 2025',
                'header' => "Thank you {$name}",
                'fromAddress' => 'youthinfo.msya@gov.tt',
                'fromName' => 'MSYA',
            ]);

            return redirect("https://msya.gov.tt/thank-you/?FirstName={$name}&ProgrammeName=GERIATRIC%20ADOLESCENT%20PARTNERSHIP%20PROGRAMME%202025%20");

        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('application.view'))
                ->withInput($request->all())
                ->with('submissionError', "There was an error in submission. {$e->getMessage()}");
        }
    }


}