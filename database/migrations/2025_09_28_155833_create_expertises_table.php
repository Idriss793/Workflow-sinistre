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
        Schema::create('expertises', function (Blueprint $table) {
            $table->id();
            $table->enum('etat_general',['excellent','bon','moyen','mauvais'])->nullable();
            $table->decimal('estimation_degats',12,2)->nullable();
            $table->text('analyse_dommages')->nullable();
            $table->text('recommandations')->nullable();
            $table->boolean('reparable')->nullable();
            $table->boolean('expertise_complementaire')->nullable();
            $table->string('expertise_path')->nullable();
            $table->string('expert_id')->nullable();
            $table->string('sinistre_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expertises');
    }
};
