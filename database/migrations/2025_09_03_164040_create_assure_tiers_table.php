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
        Schema::create('assure_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom_tiers')->nullable();
            $table->string('prenom_tiers')->nullable();
            $table->string('num_tel_tiers')->nullable();
            $table->string('num_pol_tiers')->nullable();
            $table->string('nom_assurance_tiers')->nullable();
            $table->string('contact_assurance_tiers')->nullable();
            $table->string('num_matri_tiers')->nullable();
            $table->integer('active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assure_tiers');
    }
};
