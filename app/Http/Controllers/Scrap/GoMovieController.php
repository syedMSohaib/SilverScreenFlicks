<?php

namespace App\Http\Controllers\Scrap;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MoviePlayLink;
use Illuminate\Http\Request;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoMovieController extends Controller
{

    public function index(){

        ini_set('max_execution_time', '0');

        $last_page = 980;

        for($i = 24; $i < $last_page; $i++) {

            $html = $this->apiRequest($i);

            $dom = HtmlDomParser::str_get_html($html);

            $main_div = $dom->findMulti('._smQamBQsETb');

            foreach($main_div as $div){
                $movie_name = $div->getAttribute('data-filmname');
                $gomovie_id = $div->getAttribute('data-id');
                $imdb_rating = str_replace("IMDb: ","", $div->getAttribute('data-imdb'));
                $complete   = $div->findOne('a')->getAttribute('href');

                if(trim($movie_name)){
                    $tmdb_data  = $this->getTmdbData($movie_name, "https://gomovies-online.cam{$complete}");

                    if(count($tmdb_data)){
                        $this->store($tmdb_data, null, $imdb_rating);
                        Log::info("page#{$i}: Movie - {$movie_name} is inserted into the db");
                    }
                }
            }

            sleep(2);
        }

    }

    public function store($result = [], $gomoviesurl = null, $imdb_rating = null){
        $data = [
            "TMDB_ID" => $result['id'],
            "name" => $result['original_title'],
            "description" => $result['overview'],
            "genres" => collect($result['genres'])->pluck('name')->join(','),
            "release_date" => $result['release_date'],
            "runtime" => $result['runtime'],
            "poster" => "https://www.themoviedb.org/t/p/original".$result['backdrop_path'],
            "banner" => "https://www.themoviedb.org/t/p/original".$result['poster_path'],
            "youtube_trailer" => count($result['videos']['results']) ? "https://www.youtube.com/watch?v=".$result['videos']['results'][0]['key'] : '',
            "downloadable" => 0,
            "type" => 0,
            "status" => 1,
            "content_type" => 1,
            "payload" => $result,
            "imdb_rating" => $imdb_rating,
        ];

        if(Movie::where('TMDB_ID', $result['id'])->first()) return;

        $movie = new Movie();
        $movie->fill($data);
        $movie->save();

        //adding Movie Source

        // 2Embed
        $movieSource = new MoviePlayLink();
        $movieSource->fill([
            "size" => null,
            "name" => "2Embed Server",
            "quality" => null,
            "link_order" => null,
            "movie_id" => $movie->id,
            "url" => "https://www.2embed.ru/embed/tmdb/movie?id={$result['id']}",
            "type" => "2embed",
            "status" => 1,
            "skip_available" => 0,
            "intro_start" => null,
            "intro_end" => null,
            "end_credits_marker" => 0,

        ]);
        $movieSource->save();

        // GoMovieMp4Url
        if($gomoviesurl){
            $movieSource = new MoviePlayLink();
            $movieSource->fill([
                "size" => null,
                "name" => "Go Movie Server",
                "quality" => null,
                "link_order" => null,
                "movie_id" => $movie->id,
                "url" => $gomoviesurl,
                "type" => "gomovies",
                "status" => 1,
                "skip_available" => 0,
                "intro_start" => null,
                "intro_end" => null,
                "end_credits_marker" => 0,

            ]);
            $movieSource->save();
        }
    }

    public function parseBase64($original){
        $string = base64_decode($original);
        $b = "";
        $key = "123";
        for($i = 0; $i < strlen($string); ){
            for($j = 0; ($j < strlen($key) && $i < strlen($string) ); $j++, $i++ ){
                $b .= $string[$i][0] ^ $key[$j][0];
            }
        }
        return json_decode($b);
    }

    public function getTmdbData($string, $complete = ""){
        $response = Http::get("https://api.themoviedb.org/3/search/movie?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&query={$string}&page=1&include_adult=false");
        $data = $response->json();
        // log::info("https://api.themoviedb.org/3/search/movie?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&query={$string}&page=1&include_adult=false");
        if(count($data['results'])){
            $movie = Http::get("https://api.themoviedb.org/3/movie/".$data['results'][0]['id']."?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&append_to_response=videos,images,casts,releases");
            $result = $movie->json();
            $result['gomovieurl'] = $complete;
            return $result;

        }
      return [];
    }

    public function apiRequest($current_page){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://gomovies-online.cam/all-films-1/{$current_page}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'X-Requested-With: XMLHttpRequest',
            'Cookie: advanced-frontendgomovies7=b9jra657qnrob1n563nkq49v94'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function goMovieDownloadUrl($complete){
        $curl = curl_init();
        $url = "https://gomovies-online.cam{$complete}";

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'X-Requested-With: XMLHttpRequest',
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
}
