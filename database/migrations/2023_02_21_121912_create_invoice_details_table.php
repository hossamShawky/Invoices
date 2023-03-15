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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId("invoice_id")->constrained("invoices") 
                                                     ->cascadeOnDelete();
            $table->string('invoice_number', 50);
            $table->string('product', 50);
            $table->string('Section', 999);
            $table->enum('Status', array( "مدفوعة ","مدفوعة جزئياً","غير مدفوعة" ))
            ->default("غير مدفوعة");     
            $table->enum('Value_Status',array( 0,1,2 ))->default(2);
            $table->date('Payment_Date')->nullable();
            $table->text('note')->nullable();
            $table->string('user',300);
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
        Schema::dropIfExists('invoice_details');
    }
};
