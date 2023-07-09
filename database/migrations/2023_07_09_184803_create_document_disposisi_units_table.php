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
        Schema::create('document_disposisi_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_disposisi_id')->constrained('document_disposisis')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_disposisi_units');
    }
};
