<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StceciliasPage extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'intro', 'body', 'image_path', 'image_alt', 'seo_title', 'seo_description', 'is_visible', 'sections', 'gallery', 'navigation_order', 'visitor_information'];

    protected $attributes = ['is_visible' => false, 'navigation_order' => 0];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean', 'sections' => 'array', 'gallery' => 'array', 'navigation_order' => 'integer', 'visitor_information' => 'array'];
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
