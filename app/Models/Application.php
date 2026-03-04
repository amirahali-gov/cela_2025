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
        'APL_Gender',
        'APL_Email',
        'APL_PPhone',
        'APL_APhone',
        'APL_DOB',
        'APL_Age',
        'APL_National',
        'APL_Birth_Pin',
        'APL_ID_TYP',
        'APL_ID_Number',
        'APL_CSEC_Passes',
        'APL_HLOE',
        'APL_HLOE_Specify',
        // 'APL_Employment_Status',
        // 'APL_Job_Title',
        'APL_Employment_Type',
        'APL_Training_Session',
        'APL_Volunteer_Certification',
        'APL_Specialization',
        'APL_Attendance',
        'APL_Can_Volunteer',
        'APL_Experience',
        'APL_Motivation_Expectations',
        'APL_Post_Training_Intent',
        'APL_Post_Training_Other',
        'APL_Volunteer_Confidence',
        'APL_Consent_Followup',
        'APL_How_Found_Programme',
        'APL_How_Found_Other',
        'APL_Subscribe_Mailing',
        'APL_Photo_Consent',
        'APL_Rec1_FName',
        'APL_Rec1_LName',
        'APL_Rec1_Designation',
        'APL_Rec1_Phone',
        'APL_Rec2_FName',
        'APL_Rec2_LName',
        'APL_Rec2_Designation',
        'APL_Rec2_Phone',
        'APL_Accepts',
    ];

    public function getNextId() {
        $statement = DB::select("SHOW TABLE STATUS LIKE '{$this->table}'");
        return $statement[0]->Auto_increment;
    }
}
