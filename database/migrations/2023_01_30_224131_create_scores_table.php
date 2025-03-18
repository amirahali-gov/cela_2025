<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements("SCR_ID");
            $table->integer("APL_ID")->references("APL_ID")->on("applications");
            $table->integer("LGN_ID")->references("LGN_ID")->on("logins");
            $table->smallInteger("SCR_Score");
            $table->smallInteger("SCR_Score_2");
            $table->smallInteger("SCR_Score_3");
            $table->smallInteger("SCR_Score_4");
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
        Schema::dropIfExists('scores');
    }
}
