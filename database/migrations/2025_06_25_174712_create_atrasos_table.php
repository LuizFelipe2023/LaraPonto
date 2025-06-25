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
        Schema::create('atrasos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('funcionario_id');
            $table->date('data');
            $table->string('tempo_atraso');
            $table->string('motivo')->nullable();
            $table->boolean('justificado')->default(false);
            $table->timestamps();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atrasos');
    }
};
