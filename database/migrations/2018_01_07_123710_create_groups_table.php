<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->smallInteger('emotion')->default(0);
            $table->smallInteger('heartbeat')->default(0);
            $table->smallInteger('stress_level')->default(0);
            $table->smallInteger('my_mood')->default(0);
            $table->string('notification_type')->comment('IN:minutes,live')->nullable();
            $table->string('type_data')->comment('data depending on what notification type')->nullable();
            $table->text('emotions')->comment('Example: pancake,gummybare')->nullable();
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
        Schema::dropIfExists('groups');
    }
}
