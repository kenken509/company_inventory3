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
        Schema::create('furniture_sales', function (Blueprint $table) {
            $table->id();    
            $table->string('reference_name')->nullable();                    
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');                       
            $table->unsignedBigInteger('product_model_id');                                            
            $table->integer('qty')->default('1');
            $table->double('unit_cost',15,2);
            $table->double('srp',15,2);
            $table->double('total_cost',15,2);            
            $table->integer('payment_mode')->comment('0=loan, 1=cash');  
            $table->integer('status')->default('0');          
            $table->date('date_out')->nullable();            
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
        Schema::dropIfExists('furniture_sales');
    }
};
