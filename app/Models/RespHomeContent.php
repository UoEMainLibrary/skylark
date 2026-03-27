<?php

namespace App\Models;

use Database\Seeders\RespHomeContentSeeder;
use Illuminate\Database\Eloquent\Model;

class RespHomeContent extends Model
{
    public const SLUG = 'eerc-v2-home';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
    ];

    /**
     * The single RESP v2 homepage CMS row; creates default content via seeder when missing.
     */
    public static function ensureSingleton(): self
    {
        $record = static::query()->where('slug', static::SLUG)->first();
        if ($record !== null) {
            return $record;
        }

        (new RespHomeContentSeeder)->run();

        return static::query()->where('slug', static::SLUG)->firstOrFail();
    }
}
