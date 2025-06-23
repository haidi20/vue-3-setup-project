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
        // pembukuan kas
        Schema::create('cash_books', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('account_estimate_id'); // ID estimasi akun
            $table->unsignedBigInteger('funding_source_id'); // ID sumber pendanaan
            $table->unsignedBigInteger('payment_type_id'); // ID jenis pembayaran
            $table->unsignedBigInteger('organizational_unit_id'); // ID unit organisasi

            $table->date('transaction_date');
            $table->string('document_number')->nullable(); // No dokumen
            $table->text('description')->nullable(); // Deskripsi transaksi
            $table->enum('type', ['in', 'out']); // Jenis transaksi: penerimaan atau pengeluaran
            $table->unsignedBigInteger('amount'); // Jumlah uang
            $table->string('reference')->nullable(); // Referensi tambahan

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('account_estimate_id')->references('id')->on('account_estimates')->onDelete('restrict');
            $table->foreign('funding_source_id')->references('id')->on('funding_sources')->onDelete('restrict');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('restrict');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units')->onDelete('restrict');

            // indexes
            $table->index('account_estimate_id');
            $table->index('funding_source_id');
            $table->index('payment_type_id');
            $table->index('organizational_unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_books');
    }
};
