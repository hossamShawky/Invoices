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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number', 50);
            $table->date('invoice_Date')->nullable();
            $table->date('Due_date')->nullable();
            $table->string('product', 50);
            $table->decimal('Amount_collection',8,2)->nullable();;
            $table->decimal('Amount_Commission',8,2);
            $table->decimal('Discount',8,2);
            $table->decimal('Value_VAT',8,2);
            $table->string('Rate_VAT', 999);
            $table->decimal('Total',8,2);
            $table->enum('Status', array( "مدفوعة ","مدفوعة جزئياً","غير مدفوعة" ))
            ->default("غير مدفوعة");
            $table->foreignId("section_id")->constrained("sections") 
            ->cascadeOnDelete();
            $table->enum('Value_Status',array( 0,1,2 ))->default(2);
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
