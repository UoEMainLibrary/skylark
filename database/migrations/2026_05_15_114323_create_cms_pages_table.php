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
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            // Slug-style collection key (e.g. 'eerc', 'public-art') and a
            // page slug unique within the collection. Together they form
            // the natural key the CmsPageComposer uses to look rows up.
            $table->string('collection');
            $table->string('slug');
            // Human label, surfaced as the disabled "Title" field in the
            // Filament edit form and the "Page" column in the resource list.
            $table->string('title');
            // Rich-text HTML body, rendered in the page Blade as
            // `{!! $cms->body !!}`. Nullable so a row can exist with no
            // body during initial seeding.
            $table->longText('body')->nullable();
            // Up to two optional editable images per page; per-page Blade
            // decides whether to render image_2. Path is the storage-disk
            // relative path (e.g. cms/eerc/resp/abc.jpg).
            $table->string('image_1_path')->nullable();
            $table->string('image_1_alt')->nullable();
            $table->string('image_2_path')->nullable();
            $table->string('image_2_alt')->nullable();
            $table->timestamps();

            $table->unique(['collection', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
