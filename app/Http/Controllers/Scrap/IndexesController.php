<?php

namespace App\Http\Controllers\Scrap;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MoviePlayLink;
use Illuminate\Http\Request;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndexesController extends Controller
{

    public function index(){
        ini_set('max_execution_time', '0');

        $url = "http://103.152.18.18/Data/English/hollywood/2021";

        $response = Http::get($url);

        $data = $response->body();

        $dom = HtmlDomParser::str_get_html($data);

        $main_div = $dom->findMulti('a');

        foreach($main_div as $index => $div){

            if($index){

                $movie_title = substr_replace(trim(strip_tags($div->innerText())), '', -1);

                $links = $this->parseResponse($div, $url);

                $tmdb_data = $this->getTmdbData($movie_title);

                if(count($tmdb_data)){

                    $imdb_rating = $this->fetchRatings($tmdb_data['imdb_id']);

                    $this->store($tmdb_data, $links, $imdb_rating);

                    Log::info("Movie - {$movie_title} is inserted into the db");
                }
            }
        }

        return "All Scrapping Done";

    }

    public function fetchRatings($id){
        $url = "https://p.media-imdb.com/static-content/documents/v1/title/$id/ratings%3Fjsonp=imdb.rating.run:imdb.api.title.ratings/data.json";

        $response = Http::get($url);

        $data = $response->body();

        $resp = substr_replace(str_replace("imdb.rating.run(", "", $data), '', -1);

        $output = json_decode($resp);

        Log::info([$output]);

        if($output) return $output->resource->rating ?? "";

        return "";

    }

    public function parseResponse($div, $url){

        $response = Http::get("{$url}/{$div->getAttribute('href')}");

        $data = $response->body();

        $innerdom = HtmlDomParser::str_get_html($data);

        $main_inner_div = $innerdom->findMulti('a');

        $arr = [
            'movies' => [],
            'srt' => [],
        ];

        foreach($main_inner_div as $key => $rec){
            if($key){
                // dd($movie_title);
                $url = "{$url}/{$div->getAttribute('href')}/{$rec->getAttribute('href')}";

                $ext = @pathinfo($url)['extension'];

                if($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png') continue;

                else if($ext == 'srt') array_push($arr['srt'], $url);

                else if($ext == 'mov' || $ext == 'avi' || $ext == 'mp4' || $ext == 'mkv') array_push($arr['movies'], $url);

                else continue;
            }
        }

        return $arr;
    }

    public function store($result = [], $links = [], $imdb_rating = null){
        $data = [
            "TMDB_ID" => $result['id'],
            "IMDB_ID" => $result['imdb_id'],
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

        // adding Mp4 Source

        if(count($links['movies'])){

            foreach($links['movies'] as $mov) {
                $movieSource = new MoviePlayLink();
                $movieSource->fill([
                    "size" => null,
                    "name" => "Indexing Server",
                    "quality" => null,
                    "link_order" => null,
                    "movie_id" => $movie->id,
                    "url" => $mov,
                    "type" => "mp4",
                    "status" => 1,
                    "skip_available" => 0,
                    "intro_start" => null,
                    "intro_end" => null,
                    "end_credits_marker" => 0,
                    "srt_link" => $links['srt']
                ]);
                $movieSource->save();
            }
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

        $ind = strpos($string, "(20");

        if($ind > -1) $final = trim(substr($string, 0, $ind));

        else $final = trim($string);

        $final = str_replace("&",'',$final);

        $url = "https://api.themoviedb.org/3/search/movie?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&query={$final}&page=1&include_adult=false";

        $response = Http::get($url);

        $data = $response->json();

        if(count($data['results'])){
            $movie = Http::get("https://api.themoviedb.org/3/movie/".$data['results'][0]['id']."?api_key=b591e56a62ffd2295ff3ee442f256df5&language=en-US&append_to_response=videos,images,casts,releases");
            $result = $movie->json();
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
