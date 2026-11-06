<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stcecilias_pages', function (Blueprint $table): void {
            $table->json('visitor_information')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('stcecilias_pages', function (Blueprint $table): void {
            $table->dropColumn('visitor_information');
        });
    }
};
