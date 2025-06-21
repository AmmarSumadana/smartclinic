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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Kolom untuk menyimpan ID sesi
            $table->foreignId('user_id')->nullable()->index(); // Kolom untuk menyimpan ID pengguna yang terkait
            $table->string('ip_address', 45)->nullable(); // Kolom untuk menyimpan alamat IP pengguna
            $table->text('user_agent')->nullable(); // Kolom untuk menyimpan informasi user agent
            $table->longText('payload'); // Kolom untuk menyimpan data sesi
            $table->integer('last_activity')->index(); // Kolom untuk menyimpan timestamp aktivitas terakhir
            $table->timestamps(); // Kolom untuk menyimpan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
