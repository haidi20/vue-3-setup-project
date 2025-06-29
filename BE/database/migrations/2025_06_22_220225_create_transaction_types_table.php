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
        // jenis transaksi
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Kolom untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
