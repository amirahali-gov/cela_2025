<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'VLN_Name',
        'VLN_Title',
        'VLN_Address1',
        'VLN_Address2',
        'VLN_Address3',
        'VLN_PPhone',
        'VLN_APhone',
        'VLN_Email',
        'VLN_ID_Type',
        'VLN_ID_Num',
        'VLN_Emergency_Name',
        'VLN_Emergency_Relationship',
        'VLN_Emergency_PPhone',
        'VLN_Emergency_APhone',
        'VLN_Reference1_Name',
        'VLN_Reference1_Occupation',
        'VLN_Reference1_Employer',
        'VLN_Reference1_PPhone',
        'VLN_Reference2_Name',
        'VLN_Reference2_Occupation',
        'VLN_Reference2_Employer',
        'VLN_Reference2_PPhone',
        'VLN_Assistance',
        'VLN_RegionOfInterest',
        'VLN_ConfirmResidence',
    ];
}
