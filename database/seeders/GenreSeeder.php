<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "tmdb_id" => 28,
                "name" => "Action"
            ],
            [
                "tmdb_id" => 12,
                "name" => "Adventure"
            ],
            [
                "tmdb_id" => 16,
                "name" => "Animation"
            ],
            [
                "tmdb_id" => 35,
                "name" => "Comedy"
            ],
            [
                "tmdb_id" => 80,
                "name" => "Crime"
            ],
            [
                "tmdb_id" => 99,
                "name" => "Documentary"
            ],
            [
                "tmdb_id" => 18,
                "name" => "Drama"
            ],
            [
                "tmdb_id" => 10751,
                "name" => "Family"
            ],
            [
                "tmdb_id" => 14,
                "name" => "Fantasy"
            ],
            [
                "tmdb_id" => 36,
                "name" => "History"
            ],
            [
                "tmdb_id" => 27,
                "name" => "Horror"
            ],
            [
                "tmdb_id" => 10402,
                "name" => "Music"
            ],
            [
                "tmdb_id" => 9648,
                "name" => "Mystery"
            ],
            [
                "tmdb_id" => 10749,
                "name" => "Romance"
            ],
            [
                "tmdb_id" => 878,
                "name" => "Science Fiction"
            ],
            [
                "tmdb_id" => 10770,
                "name" => "TV Movie"
            ],
            [
                "tmdb_id" => 53,
                "name" => "Thriller"
            ],
            [
                "tmdb_id" => 10752,
                "name" => "War"
            ],
            [
                "tmdb_id" => 37,
                "name" => "Western"
            ],
        ];

        foreach($data as $d){
            $genre = new Genre();
            $genre->fill($d);
            $genre->save();
        }
   }
}
