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
        Schema::create('merchadise_return_slips', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('appliances_defective_id')->nullable();
            $table->unsignedBigInteger('furniture_defective_id')->nullable(); 
            $table->date('date_out')->nullable();                                   
            $table->integer('updated_by')->nullable();  
            $table->integer('created_by')->nullable();                                   
            $table->timestamps();
            $table->foreign('appliances_defective_id')->references('id')->on('appliances_defectives')->onDelete('restrict');
            $table->foreign('furniture_defective_id')->references('id')->on('furniture_defectives')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchadise_return_slips');
    }
};
