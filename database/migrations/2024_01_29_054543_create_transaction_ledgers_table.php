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
        Schema::create('transaction_ledgers', function (Blueprint $table) {
            $table->id();
            // relationships
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('vat_id')->nullable();
            $table->unsignedBigInteger('post_account');
            $table->unsignedBigInteger('folio_account');
            $table->unsignedBigInteger('line_item_id')->nullable();
            
            // constraints
            $table->foreign('vat_id')->references('id')->on('transaction_vats');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('post_account')->references('id')->on('transaction_accounts');
            $table->foreign('folio_account')->references('id')->on('transaction_accounts');
            $table->foreign('line_item_id')->references('id')->on('transaction_line_items');

            // attributes
            $table->dateTime('posting_date', 0);
            $table->string('entry_type');
            $table->decimal('amount', 13, 4);
            $table->string('hash', 500)->nullable();
            $table->decimal('rate', 13, 4)->default(1);

            //soft deletion
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_ledgers');
    }
};
