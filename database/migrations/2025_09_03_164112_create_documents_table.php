<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * $table->foreignId('sinistre_id')->nullable()->contrained('sinistres')->onDelete('cascade');
     * $table->foreignId('user_id')->nullable()->contrained('users')->onDelete('cascade');
     * $table->foreignId('assure_id')->nullable()->constrained('assure_principals')->onDelete('cascade');
     * $table->foreignId('assure_id_tiers')->nullable()->constrained('assure_tiers')->onDelete('cascade');
     
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('type_doc')->nullable();
            $table->string('nom_fichier')->nullable();
            $table->string('path')->nullable();
            $table->string('taille')->nullable();
            $table->integer('sinistre_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('assure_id')->nullable();
            $table->integer('assure_id_tiers')->nullable();
            $table->integer('active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
