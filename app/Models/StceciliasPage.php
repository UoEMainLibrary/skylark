<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class StceciliasPage extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'intro', 'body', 'image_path', 'image_alt', 'seo_title', 'seo_description', 'is_visible', 'sections', 'gallery', 'navigation_order', 'visitor_information', 'show_in_navigation', 'navigation_label', 'navigation_parent_id', 'image_size'];

    protected $attributes = ['is_visible' => false, 'navigation_order' => 0];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean', 'sections' => 'array', 'gallery' => 'array', 'navigation_order' => 'integer', 'visitor_information' => 'array', 'show_in_navigation' => 'boolean'];
    }

    public function appearsInNavigation(): bool
    {
        return $this->show_in_navigation ?? in_array($this->slug, ['home', 'planning-your-visit', 'whats-on', 'venue-hire', 'about-us'], true);
    }

    protected static function booted(): void
    {
        static::saving(function (self $page): void {
            if ($page->navigation_parent_id) {
                $parent = self::query()->find($page->navigation_parent_id);
                if (! $parent || $parent->slug === 'home' || $parent->id === $page->id || $parent->navigation_parent_id
                    || ($page->exists && self::query()->where('navigation_parent_id', $page->id)->exists())) {
                    throw ValidationException::withMessages(['navigation_parent_id' => 'Choose a top-level page. Menus support one dropdown level.']);
                }
            }
        });
    }

    public function blogCardImageUrl(): ?string
    {
        if ($this->image_path) {
            return $this->imageUrl();
        }

        preg_match('~<img[^>]+src=["\'](/storage/stcecilias/[^"\']+)["\']~i', $this->body ?? '', $matches);

        return $matches[1] ?? null;
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
