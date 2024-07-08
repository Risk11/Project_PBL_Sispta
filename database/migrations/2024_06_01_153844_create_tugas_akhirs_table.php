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
        Schema::create('tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->string('Judul');
            $table->string('mahasiswa');
            $table->string('pembimbing1');
            $table->string('pembimbing2')->nullable();
            $table->string('dokumen_laporan_pkl')->nullable();
            $table->boolean('validasi_laporan_pkl')->default(false);
            $table->string('dokumen_lembar_pembimbing')->nullable();
            $table->boolean('validasi_lembar_pembimbing')->default(false);
            $table->string('dokumen_proposal_tugas_akhir')->nullable();
            $table->boolean('validasi_proposal_tugas_akhir')->default(false);
            $table->string('dokumen_laporan_tugas_akhir')->nullable();
            $table->boolean('validasi_laporan_tugas_akhir')->default(false);
            $table->string('status')->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhirs');
    }
};
