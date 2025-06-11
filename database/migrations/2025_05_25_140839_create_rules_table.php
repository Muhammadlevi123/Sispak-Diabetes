<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
        $table->id();
        $table->string('kode_rule', 10)->unique();
        $table->unsignedBigInteger('penyakit_id');
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->foreign('penyakit_id')->references('id')->on('penyakit')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
