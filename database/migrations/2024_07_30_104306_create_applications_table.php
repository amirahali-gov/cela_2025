<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('APL_ID');
            $table->string('APL_FName', 60)->nullable();
            $table->string('APL_MName', 60)->nullable();
            $table->string('APL_LName', 60)->nullable();
            $table->string('APL_Title', 4)->nullable();
            $table->string('APL_Address1', 90)->nullable();
            $table->string('APL_Address2', 90)->nullable();
            $table->string('APL_Address3', 90)->nullable();
            $table->string('APL_Municipality',8)->references('Board')->on('areas')->nullable();
            $table->string('APL_Gender', 1)->nullable();
            $table->date('APL_DOB')->nullable();
            $table->string('APL_PPhone', 20)->nullable();
            $table->string('APL_APhone', 20)->nullable();
            $table->string('APL_Email', 80);
            $table->string('APL_Marital', 3)->references('MAR_Code')->on('maritals');
            $table->string('APL_NID', 4)->nullable();
            $table->string('APL_NID_Number', 20)->nullable();
            $table->string('APL_BPN', 20)->nullable();
            $table->string('APL_HLOE', 2)->nullable();
            $table->string('APL_HLOE_Other', 60)->nullable();
            $table->string('APL_Has_Minimum_OLevel_Passes', 1)->nullable();
            $table->string('APL_Has_Technical_Qualifications', 1)->nullable();
            $table->string('APL_Has_Training', 1)->nullable();
            $table->string('APL_Is_Enrolled_In_Training', 1)->nullable();
            $table->string('APL_Is_Enrolled_In_YAHP', 1)->nullable();
            $table->string('APL_Income', 8)->nullable();
            $table->string('APL_Has_Dependant', 1)->nullable();
            $table->string('APL_Employment_Status', 4)->references('Employ_Code')->on('employs')->nullable();
            $table->string('APL_Employment_Status_Other', 60)->nullable();
            $table->string('APL_Housing_Status', 5)->references('HOU_Code')->on('housings')->nullable();
            $table->string('APL_Living_Status', 5)->references('LIV_Code')->on('livings')->nullable();
            $table->string('APL_Owns_Property', 1)->nullable();
            $table->string('APL_Family_Owns_Land', 1)->nullable();
            $table->string('APL_Is_Interested', 1)->nullable();
            $table->text('APL_Interest_Details')->nullable();
            $table->text('APL_Expectation')->nullable();
            $table->text('APL_Justification')->nullable();
            $table->string('APL_Has_Obligations', 1)->nullable();
            $table->text('APL_Obligations_Details')->nullable();
            $table->string('APL_Can_Attend', 1)->nullable();
            $table->string('APL_Is_First_Application', 1)->nullable();
            $table->string('APL_Source', 5)->references('SRC_Code')->on('sources')->nullable();
            $table->string('APL_Source_Other', 80)->nullable();
            $table->string('APL_Emergency_FName', 60)->nullable();
            $table->string('APL_Emergency_LName', 60)->nullable();
            $table->string('APL_Emergency_Address1', 90)->nullable();
            $table->string('APL_Emergency_Address2', 90)->nullable();
            $table->string('APL_Emergency_Address3', 90)->nullable();
            $table->string('APL_Emergency_Phone', 60)->nullable();
            $table->string('APL_Emergency_Relation', 60)->nullable();
            $table->string('APL_Recommender_FName', 60)->nullable();
            $table->string('APL_Recommender_LName', 60)->nullable();
            $table->string('APL_Recommender_Address1', 90)->nullable();
            $table->string('APL_Recommender_Address2', 90)->nullable();
            $table->string('APL_Recommender_Address3', 90)->nullable();
            $table->string('APL_Recommender_Designation', 60)->nullable();
            $table->string('APL_Recommender_Phone', 60)->nullable();
            $table->string('APL_Can_Use_Photo', 1)->nullable();
            $table->string('APL_Can_Subscribe', 1)->nullable();
            $table->string('APL_CRN', 60)->nullable();
            $table->string('APL_Accepts', 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
