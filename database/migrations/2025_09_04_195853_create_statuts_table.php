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
        Schema::create('statuts', function (Blueprint $table) {
            $table->id();
            $table->string('lib_statut')->nullable();
            $table->text('description_statut')->nullable();
            $table->integer('ordre_statut')->nullable();
            $table->integer('active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuts');
    }
};
