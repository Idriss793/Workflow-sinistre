<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * test
     * $table->foreignId('sinistre_id')->nullable()->constrained('sinistres')->onDelete('cascade');
     */
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant',10,2);
            $table->text('commentaire')->nullable();
            $table->integer('sinistre_id')->nullable();
            $table->integer('active')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
