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
        Schema::create('assure_tiers_sinistres', function (Blueprint $table) {
            $table->id();
            $table->integer('assure_tiers_id')->nullable();
            $table->integer('sinistre_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assure_tiers_sinistres');
    }
};
