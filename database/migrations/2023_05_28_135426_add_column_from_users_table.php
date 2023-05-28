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
        Schema::table('users', function (Blueprint $table) {
            // hapus kolom
            $table->dropColumn('role');
            $table->dropColumn('avatar');

            // buat kolom
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('nip')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('pns')->default(0);
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas');
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans');
            $table->string('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('nip');
            $table->dropColumn('jenis_kelamin');
            $table->dropColumn('alamat');
            $table->dropColumn('status');
            $table->dropColumn('pns');
            $table->dropColumn('foto');
            $table->string('avatar')->nullable();
            $table->enum('role',['admin','user'])->default('admin');
            $table->dropConstrainedForeignId('unit_kerja_id');
            $table->dropConstrainedForeignId('jabatan_id');
        });
    }
};
