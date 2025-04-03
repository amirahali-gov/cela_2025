<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('APL_FName');
            $table->string('APL_LName');
            $table->string('APL_Title');
            $table->string('APL_Address1');
            $table->string('APL_Address2');
            $table->string('APL_Address3');
            $table->string('APL_Municipality');
            $table->string('APL_Gender');
            $table->date('APL_DOB');
            $table->string('APL_PPhone');
            $table->string('APL_APhone')->nullable();
            $table->string('APL_Email')->unique();
            $table->string('APL_Marital');
            $table->string('APL_NID');
            $table->string('APL_NID_Number');
            $table->string('APL_BPN')->unique();
            $table->string('APL_HLOE');
            $table->string('APL_HLOE_Other')->nullable();
            $table->string('APL_Employment_Status');
            $table->string('APL_Employment_Status_Other')->nullable();
            $table->string('APL_Field')->nullable();
            $table->string('APL_Accommodation');
            $table->text('APL_Accommodation_Details')->nullable();
            $table->text('APL_Interest_Details');
            $table->string('APL_Youth_Group_Member');
            $table->string('APL_Organization_Name')->nullable();
            $table->string('APL_Role')->nullable();
            $table->string('APL_Membership_Length')->nullable();
            $table->string('APL_Availability_Virtual');
            $table->string('APL_Availability_InPerson');
            $table->string('APL_Internet');
            $table->string('APL_Obligations');
            $table->text('APL_Obligations_Details')->nullable();
            $table->string('APL_MYDNS_Participant');
            $table->text('APL_MYDNS_Participant_Details')->nullable();
            $table->text('APL_Expectations');
            $table->string('APL_NoK_Name');
            $table->string('APL_NoK_Contact');
            $table->string('APL_PG_Name')->nullable();
            $table->string('APL_PG_Contact')->nullable();
            $table->string('APL_COC_Choice');
            $table->string('APL_CRN')->nullable();
            // $table->string('File_Character_Certificate')->nullable();
            // $table->string('File_Recommender_Statement');
            // $table->string('File_Birth_Certificate');
            // $table->string('File_National_ID');
            // $table->json('Files_Academic_Certificates')->nullable();
            // $table->json('urlInput')->nullable();
            // $table->enum('APL_Accepts', ['Y']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};