<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('APL_ID');
            
            // Administrative fields - small sizes
            $table->string('APL_Dup', 1)->default('N');
            $table->string('APL_DupUser', 100)->nullable();
            $table->tinyInteger('APL_Cycle')->nullable();
            $table->string('APL_Invalid', 1)->default('N');
            $table->string('APL_Judged', 1)->default('N');
            $table->string('APL_Scored', 1)->default('N');
            $table->tinyInteger('APL_Group_Num')->default(0);
            $table->tinyInteger('APL_Sort_Num')->default(0);
            $table->string('APL_ShortList', 1)->default('N');
            
            // Personal information - moderate sizes
            $table->string('APL_FName', 100)->nullable();
            $table->string('APL_MName', 100)->nullable();
            $table->string('APL_LName', 100)->nullable();
            $table->text('APL_Address_1')->nullable();
            $table->text('APL_Address_2')->nullable();
            $table->text('APL_Address_3')->nullable();
            $table->string('APL_Area', 100)->nullable();
            $table->string('APL_Gender', 20)->nullable();
            $table->date('APL_DOB')->nullable();
            $table->integer('APL_Age')->nullable();
            
            // Contact information
            $table->string('APL_PPhone', 50)->nullable();
            $table->string('APL_APhone', 50)->nullable();
            $table->string('APL_Email', 150)->nullable();
            $table->string('APL_TT', 50)->nullable();
            
            // Identification
            $table->string('APL_ID_TYP', 50)->nullable();
            $table->string('APL_ID_Number', 100)->nullable();
            $table->string('APL_BIRTH_PIN', 100)->nullable();
            $table->string('APL_Has_NIS', 20)->nullable();
            $table->string('APL_NIS_Number', 100)->nullable();
            
            // Banking information
            $table->string('APL_BANK', 100)->nullable();
            $table->text('APL_BANK_Name')->nullable();
            $table->text('APL_BANK_Other')->nullable();
            $table->string('APL_BANK_ACC', 100)->nullable();
            
            // Service and qualification information
            $table->text('APL_Service_Area')->nullable();
            $table->string('APL_2_CXC_Passes', 20)->nullable();
            $table->string('APL_Geriatric_Certif', 20)->nullable();
            $table->string('APL_Graduate', 100)->nullable();
            $table->text('APL_Available_Weekdays')->nullable();
            $table->string('APL_Available_GAPP', 20)->nullable();
            $table->text('APL_Experience')->nullable();
            
            // Professional reference
            $table->string('APL_Prof_Rec_FName', 100)->nullable();
            $table->string('APL_Prof_Rec_LName', 100)->nullable();
            $table->text('APL_Prof_Rec_Designation')->nullable();
            $table->string('APL_Prof_Rec_Phone', 50)->nullable();
            
            // Personal reference
            $table->string('APL_Pers_Rec_FName', 100)->nullable();
            $table->string('APL_Pers_Rec_LName', 100)->nullable();
            $table->string('APL_Pers_Rec_Phone', 50)->nullable();
            $table->text('APL_Pers_Rec_Relationship')->nullable();
            
            $table->text('APL_Character_Selection')->nullable();
            $table->string('APL_CRN', 100)->nullable();
            
            // New fields from form-fields.txt
            $table->string('APL_HLOE', 100)->nullable();
            $table->text('APL_HLOE_Specify')->nullable();
            $table->string('APL_Employment_Status', 50)->nullable();
            $table->text('APL_Job_Title')->nullable();
            $table->string('APL_Employment_Type', 50)->nullable();
            $table->string('APL_Has_Bank_Account', 20)->nullable();
            $table->text('APL_Preferred_Region')->nullable();
            $table->text('APL_Certification_Institution')->nullable();
            $table->text('APL_Motivation_Expectations')->nullable();
            $table->string('APL_Post_Training_Intent', 100)->nullable();
            $table->text('APL_Post_Training_Other')->nullable();
            $table->string('APL_Consent_Followup', 20)->nullable();
            $table->text('APL_How_Found_Programme')->nullable();
            $table->text('APL_How_Found_Other')->nullable();
            $table->string('APL_Subscribe_Mailing', 20)->nullable();
            $table->string('APL_Photo_Consent', 20)->nullable();
            
            // Additional professional reference
            $table->string('APL_Prof_Rec_2_FName', 100)->nullable();
            $table->text('APL_Prof_Rec_2_Designation')->nullable();
            $table->string('APL_Prof_Rec_2_Phone', 50)->nullable();
                        
            $table->string('APL_Accepts', 20)->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};