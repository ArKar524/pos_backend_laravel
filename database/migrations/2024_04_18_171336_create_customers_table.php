<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customerCode')->unique();
            $table->string('customerName');
            $table->string("mobileNo");
            $table->date('dateOfBirth');            
            $table->enum('gender',['Male','Female','Other'])->default('Male');
            $table->string("stateCode");
            $table->string('townshipCode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

// customerCode customerName mobileNo dateOfBirth gender stateCode townshipCode