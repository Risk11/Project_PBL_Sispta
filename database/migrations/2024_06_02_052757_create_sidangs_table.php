<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sidangs', function (Blueprint $table) {
            $table->id();
            $table->string('id_tugasakhir');
            $table->date('tanggal');
            $table->integer('ruangan');
            $table->string('sesi');
            $table->string('ketua_sidang');
            $table->string('sekretaris_sidang');
            $table->string('penguji1');
            $table->string('penguji2');
            $table->string('status_kelulusan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidangs');
    }
};
