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
            $table->string('name',125);
            $table->string('slug',125)->unique();
            $table->string('supplier_code',6)->unique();
            $table->integer('status')->default(1);
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('id_no',50)->nullable();
            $table->string('age_limits',50)->nullable();
            $table->unsignedBigInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users');
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
