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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_code',10)->unique();
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('no_of_bags');
            $table->string('barcode_no');
            $table->unsignedBigInteger('quality_control_id')->index();
            $table->foreign('quality_control_id')->references('id')->on('quality_controls');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
