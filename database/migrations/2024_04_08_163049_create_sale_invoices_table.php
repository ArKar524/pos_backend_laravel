<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no');
            $table->dateTime('sale_invoice_date_time');
            $table->float('total_amount',10,2)->nullable();
            $table->float('discount',10,2)->nullable();    
            $table->float('tax', 10, 2)->nullable();
            $table->string('payment_type');
            $table->float('payment_amount',10,2);
            $table->float('receive_amount',10,2);
            $table->float('change', 10, 2)->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
