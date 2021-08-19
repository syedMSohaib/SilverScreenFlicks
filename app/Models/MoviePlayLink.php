<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoviePlayLink extends Model
{
    use HasFactory;

    protected $fillable = [
        "size",
        "name",
        "quality",
        "link_order",
        "movie_id",
        "url",
        "type",
        "status",
        "skip_available",
        "intro_start",
        "intro_end",
        "end_credits_marker",
        "srt_link",
    ];

    protected $casts = [
        'srt_link' => 'json',
    ];


}
