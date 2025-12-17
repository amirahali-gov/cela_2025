<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('APL_ID');

            // Personal Information
            $table->string('APL_FName', 255);
            $table->string('APL_MName', 255)->nullable();
            $table->string('APL_LName', 255);
            $table->string('APL_Address_1', 255);
            $table->string('APL_Address_2', 255);
            $table->string('APL_Address_3', 255);
            $table->string('APL_Gender', 20);
            $table->string('APL_Email', 255);
            $table->string('APL_PPhone', 20);
            $table->string('APL_APhone', 20);
            $table->date('APL_DOB');
            $table->string('APL_National', 1);

            // Identification
            $table->string('APL_ID_TYP', 50);
            $table->string('APL_ID_Number', 50);
            $table->string('APL_Birth_Pin', 50);

            // Education & Skills Background
            $table->string('APL_HLOE', 255);
            $table->string('APL_HLOE_Specify', 100);
            $table->string('APL_Employment_Status', 1);
            $table->string('APL_Job_Title', 255)->nullable();
            $table->string('APL_Employment_Type', 255)->nullable();
            $table->string('APL_Training_Session', 255);
            $table->string('APL_Volunteer_Certification', 1);

            // Programme Interest
            $table->string('APL_Attendance', 1);
            $table->string('APL_Can_Volunteer', 1);
            $table->text('APL_Experience');
            $table->text('APL_Motivation_Expectations');

            // Feedback
            $table->string('APL_Post_Training_Intent', 255);
            $table->text('APL_Post_Training_Other')->nullable();
            $table->string('APL_Volunteer_Confidence', 255);
            $table->string('APL_Consent_Followup', 1);
            $table->string('APL_How_Found_Programme', 255);
            $table->string('APL_How_Found_Other', 100)->nullable();
            $table->string('APL_Subscribe_Mailing', 1);
            $table->string('APL_Photo_Consent', 1);

            // Recommender Information
            $table->string('APL_Rec1_FName', 255);
            $table->string('APL_Rec1_LName', 255);
            $table->string('APL_Rec1_Designation', 255);
            $table->string('APL_Rec1_Phone', 20);
            $table->string('APL_Rec2_FName', 255);
            $table->string('APL_Rec2_LName', 255);
            $table->string('APL_Rec2_Designation', 255);
            $table->string('APL_Rec2_Phone', 20);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
