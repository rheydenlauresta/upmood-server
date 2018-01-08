<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->text('facebook_id')->unique();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('image')->default('default.png');
            $table->text('profile_post')->nullable()->comment('old: profile_status');
            $table->text('paid_emoji_set')->nullable()->comment('old: emoji_set');
            $table->string('basic_emoji_set')->default('regular')->comment('old: basic_emoji');
            $table->string('password')->nullable();
            $table->string('api_token')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('country')->nullable();
            $table->integer('record_count')->default(0);
            $table->integer('post_count')->default(0);
            $table->integer('status')->default(0);
            $table->integer('is_online')->default(0);
            $table->integer('deleted')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
