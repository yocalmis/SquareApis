<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('surname');           
            $table->string('email');
            $table->integer('tel')->nullable();
            $table->string('adress')->nullable();
            $table->boolean('status');
            $table->boolean('member_type');
            $table->integer('parent_id');
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('device')->nullable();           
            $table->integer('login_code')->nullable();  
            $table->string('key')->nullable();                                  
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
        //
        Schema::dropIfExists('users');
    }
}
