<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $table = 'analyses';

    protected $fillable = [
        'user_id',
        'url',
        'title',
        'description',
        'h1',
        'h2',
        'img_no_alt',
        'internal_links',
        'external_links',
        'https',
        'sitemap',
        'robots',
        'canonical',
        'og_tags',
        'keyword_density',
        'score'
    ];

    protected $casts = [
        'h1' => 'integer',
        'h2' => 'integer',
        'img_no_alt' => 'integer',
        'internal_links' => 'integer',
        'external_links' => 'integer',
        'https' => 'boolean',
        'sitemap' => 'boolean',
        'robots' => 'boolean',
        'canonical' => 'boolean',
        'og_tags' => 'boolean',
        'keyword_density' => 'float',
        'score' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}