<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * One row per CMS-managed page on the public site.
 *
 * Pages are keyed by (collection, slug). The catalogue of which pages are
 * managed (and how many image slots each one exposes) lives declaratively
 * in config/cms.php under `pages.<collection>.<slug>`.
 *
 * Two Filament resources scope this same table by collection — see
 * App\Filament\Resources\Resp\RespPageResource and
 * App\Filament\Resources\PublicArt\PublicArtPageResource.
 */
class CmsPage extends Model
{
    public const COLLECTION_EERC = 'eerc';

    public const COLLECTION_PUBLIC_ART = 'public-art';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'collection',
        'slug',
        'title',
        'body',
        'image_1_path',
        'image_1_alt',
        'image_2_path',
        'image_2_alt',
    ];

    /**
     * Look a single CMS page up by collection + slug. Returns null when no
     * row exists; the composer treats that as "fall back to the static
     * Blade content".
     */
    public static function lookup(string $collection, string $slug): ?self
    {
        return static::query()
            ->where('collection', $collection)
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Public URL for image 1, or null when no image has been uploaded.
     * Wraps the public-disk URL so views stay agnostic of the disk name.
     */
    public function image1Url(): ?string
    {
        return $this->image_1_path !== null
            ? Storage::disk('public')->url($this->image_1_path)
            : null;
    }

    /**
     * Public URL for image 2, or null when no image has been uploaded.
     */
    public function image2Url(): ?string
    {
        return $this->image_2_path !== null
            ? Storage::disk('public')->url($this->image_2_path)
            : null;
    }
}
