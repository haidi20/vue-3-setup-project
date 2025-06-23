<?php

use App\Models\AccountEstimate;
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
        // rekening bank

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();

            // Gunakan foreignIdFor agar otomatis kenali tabel dan kolom
            $table->foreignIdFor(AccountEstimate::class)->nullable()->constrained()->onDelete('restrict');

            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->string('branch')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indeks unik
            $table->unique(['bank_name', 'account_number', 'account_holder']);
            $table->index(['bank_name', 'account_number', 'account_holder']);
            $table->index('account_estimate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
