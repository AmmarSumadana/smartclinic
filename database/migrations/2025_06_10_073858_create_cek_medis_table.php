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
        Schema::create('cek_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel users
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 1); // 'L' or 'P'
            $table->string('no_identitas')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat', 500)->nullable();
            $table->text('penyakit_kronis')->nullable();
            $table->text('obat_rutin')->nullable();
            $table->text('alergi')->nullable();
            $table->text('riwayat_operasi')->nullable();
            $table->text('penyakit_keluarga')->nullable();
            $table->string('merokok', 50)->nullable();
            $table->string('alkohol', 50)->nullable();
            $table->string('olahraga')->nullable();
            $table->text('pola_makan')->nullable();
            $table->text('gejala')->nullable();
            $table->string('lama_gejala')->nullable();
            $table->string('tingkat_keparahan', 50)->nullable();
            $table->boolean('periksa_di_tempat')->default(false);
            $table->string('tekanan_darah')->nullable();
            $table->string('denyut_nadi')->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->float('imt')->nullable();
            $table->float('suhu')->nullable();
            $table->string('paket');
            $table->date('jadwal_tanggal');
            $table->time('jadwal_jam');
            $table->foreignId('hospital_id')->nullable()->constrained()->onDelete('set null'); // Foreign key ke tabel hospitals
            $table->text('geom')->nullable(); // Untuk menyimpan data geografis (misal: JSON)
            $table->string('pdf_path')->nullable(); // Path to generated PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cek_medis');
    }
};
