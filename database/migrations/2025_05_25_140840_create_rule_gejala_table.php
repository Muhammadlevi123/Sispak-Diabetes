<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rule_gejala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('gejala_id');
            $table->timestamps();

            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
            $table->foreign('gejala_id')->references('id')->on('gejala')->onDelete  ('cascade');
            $table->unique(['rule_id', 'gejala_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rule_gejala');
    }
};
