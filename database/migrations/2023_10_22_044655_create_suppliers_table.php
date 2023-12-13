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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 20);
            $table->string('middlename', 20)->nullable();
            $table->string('lastname', 20);
            $table->string('slug', 125)->unique();
            $table->string('supplier_code', 15)->unique();
            $table->integer('status')->default(1);
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('id_no', 50)->nullable();
            $table->unsignedBigInteger('county_id')->index();
            $table->foreign('county_id')->references('id')->on('counties');
            $table->unsignedBigInteger('subcounty_id')->index();
            $table->foreign('subcounty_id')->references('id')->on('subcounties');
            $table->string('ward', 50);
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('bank_name',125)->nullable();
            $table->string('bank_account_name',125)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
