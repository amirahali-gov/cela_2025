<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'APL_ID';
    
    protected $table = 'applications';

    protected $fillable = [
        'APL_Dup',
        'APL_DupUser',
        'APL_Cycle',
        'APL_Invalid',
        'APL_Judged',
        'APL_Scored',
        'APL_Group_Num',
        'APL_Sort_Num',
        'APL_ShortList',
        'APL_FName',
        'APL_MName',
        'APL_LName',
        'APL_Address_1',
        'APL_Address_2',
        'APL_Address_3',
        'APL_Area',
        'APL_Gender',
        'APL_DOB',
        'APL_Age',
        'APL_PPhone',
        'APL_APhone',
        'APL_Email',
        'APL_TT',
        'APL_ID_TYP',
        'APL_ID_Number',
        'APL_BIRTH_PIN',
        'APL_Has_NIS',
        'APL_NIS_Number',
        'APL_BANK',
        'APL_BANK_Name',
        'APL_BANK_Other',
        'APL_BANK_ACC',
        'APL_Service_Area',
        'APL_2_CXC_Passes',
        'APL_Geriatric_Certif',
        'APL_Graduate',
        'APL_Available_Weekdays',
        'APL_Available_GAPP',
        'APL_Experience',
        'APL_Prof_Rec_FName',
        'APL_Prof_Rec_LName',
        'APL_Prof_Rec_Designation',
        'APL_Prof_Rec_Phone',
        'APL_Pers_Rec_FName',
        'APL_Pers_Rec_LName',
        'APL_Pers_Rec_Phone',
        'APL_Pers_Rec_Relationship',
        'APL_Character_Selection',
        'APL_CRN',
        
        // New fields from form-fields.txt
        'APL_HLOE',
        'APL_HLOE_Specify',
        'APL_Employment_Status',
        'APL_Job_Title',
        'APL_Employment_Type',
        'APL_Has_Bank_Account',
        'APL_Preferred_Region',
        'APL_Certification_Institution',
        'APL_Motivation_Expectations',
        'APL_Post_Training_Intent',
        'APL_Post_Training_Other',
        'APL_Consent_Followup',
        'APL_How_Found_Programme',
        'APL_How_Found_Other',
        'APL_Subscribe_Mailing',
        'APL_Photo_Consent',
        'APL_Prof_Rec_2_FName',
        'APL_Prof_Rec_2_Designation',
        'APL_Prof_Rec_2_Phone',
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
        'File_NIS_Card',
        'APL_Accepts',
        
        // Additional fields from form-fields.txt
        'APL_Nationality',
        'APL_CSEC_Passes',
        'APL_Programme',
        'APL_Attend',
        'APL_Attend_Explanation',
        'APL_Experience_Details',
        'APL_Contact_Consent',
        'APL_Subscribe',
    ];

    public function getNextId() {
        $statement = DB::select("SHOW TABLE STATUS LIKE '{$this->table}'");
        return $statement[0]->Auto_increment;
    }
}