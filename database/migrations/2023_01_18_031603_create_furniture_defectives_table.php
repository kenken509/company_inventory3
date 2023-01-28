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
        Schema::create('furniture_defectives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_model_id');
            $table->unsignedBigInteger('supplier_id');                        
            $table->unsignedBigInteger('category_id');
            $table->string('dr_id')->nullable()->comment('deliver receipt');             
            //for later implementation
            // $table->unsignedBigInteger('ts_id')->nullable()->comment('transfer slip');            
                       
            $table->integer('qty')->default('0');
            $table->double('unit_cost')->nullable();
            $table->double('srp')->nullable();
            $table->date('date_in')->nullable();
            $table->date('date_out')->nullable();                       
            $table->integer('status')->default('1')->comment('0=returned, 1=on hand');
            $table->string('remarks')->nullable();
            $table->integer('updated_by')->nullable();  
            $table->integer('created_by')->nullable();
            $table->foreign('product_model_id')->references('id')->on('furniture_products')->onDelete('restrict');             
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
        Schema::dropIfExists('furniture_defectives');
    }
};
