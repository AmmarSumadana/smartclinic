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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pasien yang menjadwalkan

            // KUNCI PERBAIKAN: Ubah foreign key untuk doctor_id agar merujuk ke tabel 'users'
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade'); // Dokter yang dikonsultasikan

            $table->dateTime('consultation_date'); // Tanggal dan waktu konsultasi yang dijadwalkan
            $table->text('notes')->nullable(); // Catatan dari pasien (pesan pasien)
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending'); // Status konsultasi
            $table->foreignId('responded_by_user_id')->nullable()->constrained('users')->onDelete('set null'); // Opsional: Siapa pegawai/dokter yang memproses
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
