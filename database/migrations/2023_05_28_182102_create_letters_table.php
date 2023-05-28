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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->nullable()->constrained('users');
            $table->foreignId('to_user_id')->nullable()->constrained('users');
            $table->date('tanggal');
            $table->string('hal');
            $table->text('deskripsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
