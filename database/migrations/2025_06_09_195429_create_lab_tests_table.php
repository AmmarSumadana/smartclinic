<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('test_type');
            $table->dateTime('test_date');
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lab_tests');
    }
};
