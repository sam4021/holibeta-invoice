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
        Schema::create('quality_controls', function (Blueprint $table) {
            $table->id();
            $table->string('qc_code', 10)->unique();
            $table->unsignedBigInteger('weighbridge_id')->index();
            $table->foreign('weighbridge_id')->references('id')->on('weighbridges');
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('visual_inspection');
            $table->string('visual_inspection_comment');
            $table->string('visual_inspection_image')->nullable();
            $table->string('moisture_content');
            $table->string('aflatoxin_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_controls');
    }
};
