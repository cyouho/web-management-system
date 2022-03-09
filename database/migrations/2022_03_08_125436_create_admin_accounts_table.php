<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('admin_id')->unique();
            $table->string('admin_role');
            $table->string('admin_name');
            $table->string('admin_email')->unique();
            $table->string('admin_session')->nullable();
            $table->timestamps();
            $table->timestamp('last_login_at');
            $table->timestamp('total_login_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accounts');
    }
}
