<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
     * $table->foreignId('statut_id')->nullable()->constrained('statuts')->onDelete('cascade');
     */
    public function up(): void
    {
        Schema::create('sinistres', function (Blueprint $table) {
            $table->id();
            $table->string('numero_sinistre')->unique();
            $table->string('date_sinistre')->nullable();
            $table->string('lieu')->nullable();
            $table->text('description')->nullable();
            $table->string('type_sinistre')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('statut_id')->nullable();
            $table->integer('active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinistres');
    }
};
