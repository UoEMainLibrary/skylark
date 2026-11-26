<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stcecilias_pages', function (Blueprint $table): void {
            $table->boolean('show_in_navigation')->nullable();
            $table->string('navigation_label')->nullable();
            $table->foreignId('navigation_parent_id')->nullable()->constrained('stcecilias_pages')->nullOnDelete();
            $table->string('image_size')->default('full');
        });
    }

    public function down(): void
    {
        Schema::table('stcecilias_pages', function (Blueprint $table): void {
            $table->dropForeign(['navigation_parent_id']);
            $table->dropColumn(['show_in_navigation', 'navigation_label', 'navigation_parent_id', 'image_size']);
        });
    }
};
