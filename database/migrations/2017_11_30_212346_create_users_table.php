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
            $table->string('username',30);
            $table->string('password',45);
            $table->string('name',255);
            $table->tinyInteger('gender');
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique();
            // level: 0: member, 1: sub-leader, 2: leader, 3: admin
            $table->tinyInteger('level');
            $table->unsignedInteger('team_id');
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
