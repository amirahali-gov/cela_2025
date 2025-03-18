<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $primaryKey = 'UPD_ID';
    
    protected $fillable = [
        'UPD_APL_ID',
        'UPD_DocName',
        'UPD_Desc',
        'UPD_FilePath',
    ];
}
