<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // PERBAIKI: Ganti 'rawat_inap_table' menjadi 'rawat_inap'
        Schema::table('rawat_inap', function (Blueprint $table) {
            // Cek apakah kolom user_id sudah ada
            if (!Schema::hasColumn('rawat_inap', 'user_id')) { // PERBAIKI: Ganti 'rawat_inap_table'
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('id');
            }
            // Cek apakah kolom status sudah ada
            if (!Schema::hasColumn('rawat_inap', 'status')) { // PERBAIKI: Ganti 'rawat_inap_table'
                $table->string('status')->default('pending')->after('kartu_asuransi_path'); // Setelah kartu_asuransi_path
            }
            // Cek apakah kolom room_number sudah ada
            if (!Schema::hasColumn('rawat_inap', 'room_number')) { // PERBAIKI: Ganti 'rawat_inap_table'
                $table->string('room_number')->nullable()->after('status');
            }
            // Cek apakah kolom notes sudah ada
            if (!Schema::hasColumn('rawat_inap', 'notes')) { // PERBAIKI: Ganti 'rawat_inap_table'
                $table->text('notes')->nullable()->after('room_number');
            }
        });
    }

    public function down()
    {
        // PERBAIKI: Ganti 'rawat_inap_table' menjadi 'rawat_inap'
        Schema::table('rawat_inap', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['user_id']);
            // Kemudian drop kolomnya
            $table->dropColumn(['user_id', 'status', 'room_number', 'notes']);
        });
    }
};
