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
            $table->string('security_check_code', 10)->unique();
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('vehicle_type', 125);
            $table->string('vehicle_reg_no', 125);
            $table->string('vehicle_plate_front', 125);
            $table->string('vehicle_plate_back', 125);
            $table->string('front_image', 125)->nullable();
            $table->string('back_image', 125)->nullable();
            $table->string('side_image', 125)->nullable();
            $table->string('top_image', 125)->nullable();
            $table->unsignedBigInteger('driver_id')->index();
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->string('timeslot', 40)->nullable();
            $table->unsignedBigInteger('county_id')->index();
            $table->foreign('county_id')->references('id')->on('counties');
            $table->unsignedBigInteger('subcounty_id')->index();
            $table->foreign('subcounty_id')->references('id')->on('subcounties');
            $table->string('village', 125);
            $table->integer('no_of_bags');
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
