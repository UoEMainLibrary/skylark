<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StceciliasEvent extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'intro', 'body', 'image_path', 'image_alt', 'seo_title', 'seo_description', 'is_visible', 'starts_at', 'ends_at', 'category', 'venue', 'price', 'booking_url'];

    protected $attributes = ['is_visible' => false];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean', 'starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
