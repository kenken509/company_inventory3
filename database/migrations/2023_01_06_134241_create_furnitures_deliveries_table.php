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
        Schema::create('furnitures_deliveries', function (Blueprint $table) {
            $table->id();                        
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');                       
            $table->unsignedBigInteger('product_model_id');                                
            $table->integer('qty')->default('0');
            $table->double('unit_cost',15,2)->nullable();
            $table->double('srp',15,2)->nullable();
            $table->string('reference_name')->nullable();              
            $table->integer('status')->default('0')->comment('1=defective 0=prestine');          
            $table->date('date_in')->nullable();            
            $table->string('remarks')->nullable();
            $table->integer('updated_by')->nullable();  
            $table->integer('created_by')->nullable(); 
            $table->foreign('supplier_id')->references('id')->on('furniture_suppliers')->onDelete('restrict'); // $table->foreign('field on current table')->references('id')->on('related table')->onDelete('restrict')
            $table->foreign('category_id')->references('id')->on('furniture_categories')->onDelete('restrict');            
            $table->foreign('product_model_id')->references('id')->on('furniture_products')->onDelete('restrict');                         
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
        Schema::dropIfExists('furnitures_deliveries');
    }
};
