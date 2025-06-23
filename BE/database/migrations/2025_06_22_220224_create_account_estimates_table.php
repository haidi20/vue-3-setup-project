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
            $table->unsignedBigInteger('account_category_id'); // ID estimasi akun
            $table->unsignedBigInteger('account_type_id'); // ID jenis akun

            $table->string('name');
            $table->text('description')->nullable();
            // Saldo Normal (Debit/Kredit)
            $table->enum('normal_balance', ['debit', 'credit'])->default('debit');

            $table->timestamps();
            $table->softDeletes();

            // Relasi ke tabel account_categories
            $table->foreign('account_category_id')->references('id')->on('account_categories')->onDelete('restrict');
            // Relasi ke tabel account_types
            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('restrict');

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
