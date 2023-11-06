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
        Schema::create('security_checks', function (Blueprint $table) {
            $table->id();
            $table->string('security_check_code',10)->unique();
            $table->unsignedBigInteger('supplier_id')->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('vehicle_reg_no',125);
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->string('front_image',125)->nullable();
            $table->string('back_image',125)->nullable();
            $table->string('side_image',125)->nullable();
            $table->unsignedBigInteger('driver')->index();
            $table->foreign('driver')->references('id')->on('drivers');
            $table->string('timeslot',50);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_checks');
    }
};
