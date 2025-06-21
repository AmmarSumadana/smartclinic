<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilResepsTable extends Migration
{
    public function up()
    {
        Schema::create('hasil_reseps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Mengaitkan dengan tabel users
            $table->string('medicine_name');
            $table->string('dosage');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_reseps');
    }
}

