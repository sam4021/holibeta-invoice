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
        Schema::create('subcounties', function (Blueprint $table) {
            $table->id();
            $table->string('name',125)->unique();
            $table->string('slug', 150)->unique();
            $table->unsignedBigInteger('county_id')->index();
            $table->foreign('county_id')->references('id')->on('counties');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcounties');
    }
};