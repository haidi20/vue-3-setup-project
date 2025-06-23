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
        Schema::create('account_estimates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // Saldo Normal (Debit/Kredit)
            $table->enum('normal_balance', ['debit', 'credit'])->default('debit');

            // Relasi ke tabel account_categories
            $table->foreignId('account_category_id')->constrained('account_categories')->onDelete('restrict');
            // Relasi ke tabel account_types
            $table->foreignId('account_type_id')->constrained('account_types')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();

            // Indeks untuk performa query
            $table->index('account_category_id');
            $table->index('account_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_estimates', function (Blueprint $table) {
            // Hapus foreign key & index
            $table->dropForeign(['account_category_id']);
            $table->dropIndex(['account_category_id']);
            $table->dropForeign(['account_type_id']);
            $table->dropIndex(['account_type_id']);
        });

        Schema::dropIfExists('account_estimates');
    }
};
