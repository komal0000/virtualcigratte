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
        Schema::table('cigaratte_collections', function (Blueprint $table) {
            $table->boolean('published_at')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cigaratte_collections', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
};
