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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('from_user_id')->nullable()->constrained('users');
            $table->foreignId('to_unit_kerja_id')->nullable()->constrained('unit_kerjas');
            $table->foreignId('to_tembusan_unit_kerja_id')->nullable()->constrained('unit_kerjas');
            $table->string('kode_hal');
            $table->string('hal');
            $table->text('deskripsi');
            $table->text('keterangan');
            $table->text('body');
            $table->timestamp('read_at')->nullable();
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
