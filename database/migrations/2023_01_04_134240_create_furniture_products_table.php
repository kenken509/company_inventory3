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
        Schema::create('furniture_products', function (Blueprint $table) {
            $table->id();    
            $table->unsignedBigInteger('supplier_id');                    
            $table->unsignedBigInteger('category_id');             
            $table->string('product_model');   
            $table->integer('qty')->default('0');
            $table->double('unit_cost',15,2)->nullable(); 
            $table->double('srp_gdp',15,2)->nullable();  
            $table->double('total_gdp',15,2)->storedAs('qty * srp_gdp')->nullable();                     
            $table->string('description')->nullable();                                                                             
            $table->integer('updated_by')->nullable();  
            $table->integer('created_by')->nullable();                                            
            $table->integer('status')->default('0')->comment('0=prestine, 1=defective');                                  
            $table->foreign('supplier_id')->references('id')->on('furniture_suppliers')->onDelete('restrict'); // $table->foreign('field on current table')->references('id')->on('related table')->onDelete('restrict')
            $table->foreign('category_id')->references('id')->on('furniture_categories')->onDelete('restrict');                                                                           
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
        Schema::dropIfExists('furniture_products');
    }
};
