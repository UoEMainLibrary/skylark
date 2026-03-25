<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'collection',
        'slug',
        'title',
        'body',
    ];
}
