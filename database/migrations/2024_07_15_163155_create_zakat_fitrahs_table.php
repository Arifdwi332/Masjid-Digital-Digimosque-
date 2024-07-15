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
        Schema::create('zakat_fitrahs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_muzaki');
            $table->INT('berat_beras');
            $table->string('asal_desa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zakat_fitrahs');
    }
};
