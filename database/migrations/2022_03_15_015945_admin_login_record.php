<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminLoginRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_login_record', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('record_id')->unique();
            $table->integer('admin_id');
            $table->timestamp('login_at');
            $table->integer('login_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_login_record');
    }
}
