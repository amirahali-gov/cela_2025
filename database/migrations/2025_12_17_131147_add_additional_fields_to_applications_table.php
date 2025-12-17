<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('APL_Dup')->default('N');
            $table->string('APL_DupUser')->default('N');
            $table->string('APL_Invalid')->default('N');
            $table->string('APL_Judged')->default('N');
            $table->integer('APL_Scored')->default(0);
            $table->integer('APL_Group_Num')->default(0);
            $table->integer('APL_Sort_Num')->default(0);
            $table->string('APL_ShortList')->default('N');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'APL_Dup',
                'APL_DupUser',
                'APL_Invalid',
                'APL_Judged',
                'APL_Scored',
                'APL_Group_Num',
                'APL_Sort_Num',
                'APL_ShortList',
            ]);
        });
    }
}
