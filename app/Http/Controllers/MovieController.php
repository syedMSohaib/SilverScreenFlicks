<?php

namespace App\Http\Controllers;

use App\Filters\MovieFilter;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{

    public function index(Request $request, MovieFilter $filters){
        $movies = Movie::with('links')->filter($filters);

        $movies = $movies->paginate(30);

        return $movies;
    }


    public function show(Request $request, Movie $movie){
        return $movie->load('links');
    }


    public function search(Request $request, MovieFilter $filters) {

        if(!$request->query('title')) return  [];

        $movies = Movie::filter($filters)->latest()->paginate(30);

        return $movies;
    }


    public function trending(Request $request) {

        $response = Http::get('https://api.themoviedb.org/3/trending/all/day?api_key=b591e56a62ffd2295ff3ee442f256df5');

        return $response->json();
    }


    public function recommendations(Request $request, $tmdb) {

        $response = Http::get("https://api.themoviedb.org/3/movie/{$tmdb}/recommendations?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&page=1");

        return $response->json();
    }

    public function similar(Request $request, $tmdb) {

        $response = Http::get("https://api.themoviedb.org/3/movie/{$tmdb}/similar?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&page=1");

        return $response->json();
    }

    public function upcoming(Request $request) {

        $response = Http::get("https://api.themoviedb.org/3/movie/upcoming?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&page=1");

        return $response->json();
    }
}

