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
        Schema::table('documents', function (Blueprint $table) {
            $table->longText('visum_umum')->nullable()->change();
            $table->foreignId('tte_visum_umum_created_user_id')->nullable()->constrained('users');
            $table->dateTime('tte_visum_umum_created')->nullable();
            $table->string('visum_umum_qrcode')->nullable();
            $table->string('tte_visum_umum_file')->nullable();

            $table->longText('spd')->nullable()->change();
            $table->foreignId('tte_spd_created_user_id')->nullable()->constrained('users');
            $table->dateTime('tte_spd_created')->nullable();
            $table->string('spd_qrcode')->nullable();
            $table->string('tte_spd_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('visum_umum')->nullable()->change();
            $table->dropConstrainedForeignId('tte_visum_umum_created_user_id');
            $table->dropColumn('tte_visum_umum_created');
            $table->dropColumn('visum_umum_qrcode');
            $table->dropColumn('tte_visum_umum_file');

            $table->string('spd')->nullable()->change();
            $table->dropConstrainedForeignId('tte_spd_created_user_id');
            $table->dropColumn('tte_spd_created');
            $table->dropColumn('spd_qrcode');
            $table->dropColumn('tte_spd_file');

        });
    }
};
