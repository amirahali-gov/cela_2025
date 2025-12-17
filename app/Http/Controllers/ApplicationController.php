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

        /* =======================
        | Personal Information
        ======================= */
        'APL_FName'        => 'required|string|max:255',
        'APL_MName'        => 'nullable|string|max:255',
        'APL_LName'        => 'required|string|max:255',

        'APL_Address_1'    => 'required|string|max:255',
        'APL_Address_2'    => 'required|string|max:255',
        'APL_Address_3'    => 'required|string',

        'APL_Gender'       => 'required|in:M,F',
        'APL_Email'        => 'required|email|max:255',
        'APL_PPhone'       => 'required|string|max:20',
        'APL_APhone'       => 'nullable|string|max:20',

        'APL_DOB'          => 'required|date',
        'APL_National'     => 'required|in:Y,N',

        /* =======================
        | Identification
        ======================= */
        'APL_ID_TYP'       => 'required|in:NID,PP',
        'APL_ID_Number'    => 'required|string|max:50',
        'APL_Birth_Pin'    => 'required|string|max:50',

        /* =======================
        | Education & Skills
        ======================= */
        'APL_HLOE'             => 'required|string',
        'APL_HLOE_Specify'     => 'required_if:APL_HLOE,Technical/Vocational|nullable|string|max:100',

        /* =======================
        | Employment
        ======================= */
        'APL_Employment_Status' => 'required|in:Y,N',
        'APL_Job_Title'         => 'required_if:APL_Employment_Status,Y|nullable|string|max:255',
        'APL_Employment_Type'   => 'required_if:APL_Employment_Status,Y|nullable|string|max:255',

        /* =======================
        | Programme & Training
        ======================= */
        'APL_Training_Session'        => 'required|string',
        'APL_Volunteer_Certification' => 'required|in:Y,N',

        'APL_Attendance'      => 'required|in:Y,N',
        'APL_Can_Volunteer'   => 'required|in:Y,N',

        'APL_Experience'               => 'required|string|max:1000',
        'APL_Motivation_Expectations'  => 'required|string|max:1000',

        /* =======================
        | Feedback
        ======================= */
        'APL_Post_Training_Intent' => 'required|string',
        'APL_Post_Training_Other'  => 'required_if:APL_Post_Training_Intent,Other|nullable|string|max:255',

        'APL_Volunteer_Confidence' => 'required|string',
        'APL_Consent_Followup'     => 'required|in:Y,N',

        'APL_How_Found_Programme'  => 'required|string',
        'APL_How_Found_Other'      => 'required_if:APL_How_Found_Programme,Other|nullable|string|max:255',

        'APL_Subscribe_Mailing' => 'required|in:Y,N',
        'APL_Photo_Consent'     => 'required|in:Y,N',

        /* =======================
        | Recommenders
        ======================= */
        'APL_Rec1_FName'        => 'required|string|max:255',
        'APL_Rec1_LName'        => 'required|string|max:255',
        'APL_Rec1_Designation'  => 'required|string|max:255',
        'APL_Rec1_Phone'        => 'required|string|max:20',

        'APL_Rec2_FName'        => 'required|string|max:255',
        'APL_Rec2_LName'        => 'required|string|max:255',
        'APL_Rec2_Designation'  => 'required|string|max:255',
        'APL_Rec2_Phone'        => 'required|string|max:20',

        /* =======================
        | File Uploads
        ======================= */
        // 'File_Birth_Certificate'        => 'required|file',
        // 'File_National_ID'              => 'required|file',
        // 'File_Proof_Address'            => 'required|file',

    //     'File_Authorization_Letter'     => 'nullable|file',
    //     'File_Owner_ID'                 => 'nullable|file',
    //     'Files_Academic_Certificates'   => 'nullable',
    //     'File_Recommender_Statement_1'  => 'required|file',
    //     'File_Recommender_Statement_2'  => 'required|file',
    ];


    private function getAttributeNames()
    {
        return [

            /* Personal Information */
            'APL_FName'       => 'First Name',
            'APL_MName'       => 'Middle Name',
            'APL_LName'       => 'Last Name',
            'APL_Address_1'   => 'Address Line 1',
            'APL_Address_2'   => 'Address Line 2',
            'APL_Address_3'   => 'Area',
            'APL_Gender'      => 'Gender',
            'APL_Email'       => 'Email Address',
            'APL_PPhone'      => 'Contact Number',
            'APL_APhone'      => 'Alternative Contact Number',
            'APL_DOB'         => 'Date of Birth',
            'APL_National'    => 'Nationality Confirmation',

            /* Identification */
            'APL_ID_TYP'      => 'Identification Type',
            'APL_ID_Number'   => 'Identification Number',
            'APL_Birth_Pin'   => 'Birth Certificate PIN',

            /* Education & Employment */
            'APL_HLOE'             => 'Highest Level of Education',
            'APL_HLOE_Specify'     => 'Education Specification',
            'APL_Employment_Status'=> 'Employment Status',
            'APL_Job_Title'        => 'Job Title',
            'APL_Employment_Type'  => 'Employment Type',

            /* Programme */
            'APL_Training_Session'        => 'Preferred Training Facility',
            'APL_Volunteer_Certification' => 'Volunteer Certification',
            'APL_Attendance'              => 'Session Attendance',
            'APL_Can_Volunteer'           => 'Volunteer Availability',
            'APL_Experience'              => 'Volunteer Experience',
            'APL_Motivation_Expectations' => 'Motivation & Expectations',

            /* Feedback */
            'APL_Post_Training_Intent' => 'Post Training Intent',
            'APL_Post_Training_Other'  => 'Other Post Training Plan',
            'APL_Volunteer_Confidence' => 'Confidence Level',
            'APL_Consent_Followup'     => 'Follow-up Consent',
            'APL_How_Found_Programme'  => 'Programme Source',
            'APL_How_Found_Other'      => 'Other Programme Source',
            'APL_Subscribe_Mailing'    => 'Mailing List Subscription',
            'APL_Photo_Consent'        => 'Photo Consent',

            /* Recommenders */
            'APL_Rec1_FName'       => 'Recommender 1 First Name',
            'APL_Rec1_LName'       => 'Recommender 1 Last Name',
            'APL_Rec1_Designation' => 'Recommender 1 Designation',
            'APL_Rec1_Phone'       => 'Recommender 1 Phone',

            'APL_Rec2_FName'       => 'Recommender 2 First Name',
            'APL_Rec2_LName'       => 'Recommender 2 Last Name',
            'APL_Rec2_Designation' => 'Recommender 2 Designation',
            'APL_Rec2_Phone'       => 'Recommender 2 Phone',

            /* Files */
            'File_Birth_Certificate'       => 'Birth Certificate',
            'File_National_ID'             => 'National ID / Passport',
            'File_Proof_Address'           => 'Proof of Address',
            'File_Authorization_Letter'    => 'Authorization Letter',
            'File_Owner_ID'                => 'Owner Identification',
            'Files_Academic_Certificates'  => 'Academic Certificates',
            'File_Recommender_Statement_1' => 'Recommender Statement 1',
            'File_Recommender_Statement_2' => 'Recommender Statement 2',
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
        'File_Birth_Certificate'       => 'single',
        'File_National_ID'             => 'single',
        'File_Proof_Address'           => 'single',
        'File_Authorization_Letter'    => 'single',
        'File_Owner_ID'                => 'single',
        'Files_Academic_Certificates'  => 'multi',  // multiple files
        'File_Recommender_Statement_1' => 'single',
        'File_Recommender_Statement_2' => 'single',
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
            Log::channel('applicant')->warning('Application submission failed, validation errors', ['errors' => $validator->errors(), 'allInput' => $allInput]);
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
            $application->APL_Address_3 = Area::where('Area_CC', $validated['APL_Address_3'])->value('Board');
            $application->APL_Age = Carbon::parse($validated['APL_DOB'])->age;
            if($validated['APL_Address_3'] == 'Other'){
                $application->APL_Address_3 = ucwords(strtolower($validated['APL_Address_3_Other']));
            }
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

            Log::channel('applicant')->notice('Application submitted', ['application' => $application]);

            // Clean up
            $uploadedFilesSession = session()->get('uploadedFiles', []);
            foreach ($uploadedFilesSession as $field => $files) {
                if (!is_array($files)) continue;

                foreach ($files as $file) {
                    $path = $file['path'] ?? null;
                    if ($path && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            session()->forget('uploadedFiles');

            $name = "{$application->APL_FName} {$application->APL_LName}";
            Http::withHeaders([
                'appID' => env('SWIFT_APP_ID'), 
                'Authorization' => 'Bearer ' . env('SWIFT_TOKEN'), 
            ])->post('https://swift.msya.gov.tt/api/general', [
                'email' => $application->APL_Email,
                'title' => 'Creative Faces 2025',
                'subject' => 'Creative Faces 2025 APPLICATION',
                'name' => $name,
                'body' => 'This email serves to inform you that your application has been received.',
                'app' => 'CREATIVE FACES 2025',
                'header' => "Thank you {$name}",
                'fromAddress' => 'youthinfo.msya@gov.tt',
                'fromName' => 'MSYA',
            ]);

            return redirect("https://msya.gov.tt/thank-you/?FirstName={$name}&ProgrammeName=CREATIVE%20FACES%202025%20");

        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('applicant')->error('Application submission failed', ['error' => $e->getMessage()]);
            return redirect(route('application.view'))
                ->withInput($request->all())
                ->with('submissionError', "There was an error in submission. {$e->getMessage()}");
        }
    }

}