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
            $table->foreignId('tte_created_user_id')->nullable()->constrained('users');
            $table->timestamp('tte_created')->nullable();
            $table->string('tte_file')->nullable();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tte_created_user_id');
            $table->dropColumn('tte_created');
            $table->dropColumn('tte_file');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
