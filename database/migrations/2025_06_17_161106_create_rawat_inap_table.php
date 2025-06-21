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
        Schema::create('rawat_inap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('patient_name'); // Nama pasien yang mendaftar
            $table->string('hospital_name'); // Nama rumah sakit tujuan
            $table->string('room_number')->nullable(); // Nomor kamar, mungkin diisi nanti oleh admin
            $table->text('reason'); // Alasan rawat inap
            $table->string('status')->default('pending'); // Status pendaftaran: pending, approved, rejected, admitted, discharged
            $table->date('admission_date')->nullable(); // Tanggal masuk yang diinginkan/disetujui
            $table->date('discharge_date')->nullable(); // Tanggal keluar (jika sudah selesai rawat inap)
            $table->string('ktp_path'); // Path file KTP yang diupload
            $table->string('surat_pengantar_path'); // Path file Surat Pengantar Dokter
            $table->string('kartu_asuransi_path')->nullable(); // Path file Kartu Asuransi (opsional)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_inap');
    }
};
