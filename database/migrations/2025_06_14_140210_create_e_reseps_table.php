<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEResepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_reseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('medicine_name');
            $table->string('generic_name');
            $table->string('form'); // tablet, kapsul, sirup, dll
            $table->text('indication'); // indikasi/kegunaan obat
            $table->text('dosage'); // aturan pakai
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('category')->nullable(); // kategori obat
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled', 'template'])->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index untuk pencarian
            $table->index(['medicine_name', 'generic_name']);
            $table->index('indication');
            $table->index('category');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_reseps');
    }
}
