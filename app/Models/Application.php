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
        'APL_FName',
        'APL_MName',
        'APL_LName',
        'APL_Title',
        'APL_Address1',
        'APL_Address2',
        'APL_Address3',
        'APL_Municipality',
        'APL_Gender',
        'APL_DOB',
        'APL_PPhone',
        'APL_APhone',
        'APL_Email',
        'APL_Marital',
        'APL_NID',
        'APL_NID_Number',
        'APL_BPN',
        'APL_HLOE',
        'APL_HLOE_Other',
        'APL_Has_Minimum_OLevel_Passes',
        'APL_Has_Technical_Qualifications',
        'APL_Has_Training',
        'APL_Is_Enrolled_In_Training',
        'APL_Is_Enrolled_In_YAHP',
        'APL_Income',
        'APL_Has_Dependant',
        'APL_Employment_Status',
        'APL_Employment_Status_Other',
        'APL_Housing_Status',
        'APL_Living_Status',
        'APL_Owns_Property',
        'APL_Family_Owns_Land',
        'APL_Is_Interested',
        'APL_Interest_Details',
        'APL_Expectation',
        'APL_Justification',
        'APL_Has_Obligations',
        'APL_Obligations_Details',
        'APL_Can_Attend',
        'APL_Is_First_Application',
        'APL_Source',
        'APL_Source_Other',
        'APL_Emergency_FName',
        'APL_Emergency_LName',
        'APL_Emergency_Address1',
        'APL_Emergency_Address2',
        'APL_Emergency_Address3',
        'APL_Emergency_Phone',
        'APL_Emergency_Relation',
        'APL_Recommender_FName',
        'APL_Recommender_LName',
        'APL_Recommender_Address1',
        'APL_Recommender_Address2',
        'APL_Recommender_Address3',
        'APL_Recommender_Designation',
        'APL_Recommender_Phone',
        'APL_Can_Use_Photo',
        'APL_Can_Subscribe',
        'APL_CRN',
        'APL_Accepts',
    ];

    public function getNextId() {
        $statement = DB::select("SHOW TABLE STATUS LIKE '{$this->table}'");
        return $statement[0]->Auto_increment;
    }
}