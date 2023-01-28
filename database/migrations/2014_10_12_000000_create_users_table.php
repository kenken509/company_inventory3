<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) { //Schema::create('tableName', function (Blueprint $table)
            $table->id();
            $table->string('name');
            $table->string('profile_image')->nullable();
            $table->string('email');
            $table->bigInteger('mobile_no')->nullable();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->default(0)->comment('1=admin, 2=inventory clerk, 0=customer');; 
            $table->tinyInteger('created_by')->nullable();           
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
};
