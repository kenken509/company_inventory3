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
        Schema::create('appliances', function (Blueprint $table) {
            $table->id();                        
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');            
            $table->unsignedBigInteger('brand_id');   
            $table->string('description')->nullable();                     
            $table->string('product_model');            
            $table->integer('qty')->default('0');
            $table->double('unit_cost',15,2)->nullable();
            $table->double('srp',15,2)->nullable();
            $table->string('reference_in')->nullable();
            $table->string('reference_out')->nullable();
            $table->date('date_in')->nullable();
            $table->date('date_out')->nullable();
            $table->integer('status')->default('0');
            $table->string('remarks')->nullable();
            $table->integer('updated_by')->nullable();  
            $table->integer('created_by')->nullable(); 
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict'); // $table->foreign('field on current table')->references('id')->on('related table')->onDelete('restrict')
            $table->foreign('category_id')->references('id')->on('appliances_categories')->onDelete('restrict'); 
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('restrict');                                                              
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
        Schema::dropIfExists('appliances');
    }
};
