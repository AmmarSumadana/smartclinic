<?php
// database/migrations/xxxx_xx_xx_create_layanan_ambulans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanan_ambulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hospital_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama_pasien');
            $table->string('nomor_telepon');
            $table->text('alamat_penjemputan');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi', 'darurat']);
            $table->text('deskripsi_kondisi')->nullable();
            $table->enum('status', [
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'dalam_perjalanan',
                'tiba_di_lokasi',
                'menuju_rumah_sakit',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_konfirmasi');
            $table->timestamp('waktu_permintaan')->useCurrent();
            $table->timestamp('estimasi_tiba')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan_ambulans');
    }
};
