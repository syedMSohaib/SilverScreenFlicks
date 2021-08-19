<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public $fillable = [
        "TMDB_ID",
        "IMDB_ID",
        "name",
        "description",
        "genres",
        "release_date",
        "runtime",
        "poster",
        "banner",
        "youtube_trailer",
        "downloadable",
        "type",
        "status",
        "content_type",
        "payload",
        "imdb_rating"
    ];

    protected $casts = [
        'payload' => 'json',
    ];

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function links(){
        return $this->hasMany(MoviePlayLink::class, 'movie_id');
    }
}
