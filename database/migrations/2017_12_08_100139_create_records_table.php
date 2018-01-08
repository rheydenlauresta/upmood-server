<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('value: automated, manual')->default('automated');
            $table->integer('user_id');
            $table->string('stress_level');
            $table->integer('heartbeat_count');
            $table->string('emotion_value');
            $table->string('emotion_level');
            $table->string('longitude');
            $table->string('latitude');
            $table->text('ppi');
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
        Schema::dropIfExists('records');
    }
}
