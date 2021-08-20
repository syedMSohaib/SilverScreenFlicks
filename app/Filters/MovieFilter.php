<?php

namespace App\Filters;
use App\Filters\Filters;
use Illuminate\Support\Facades\DB;

class MovieFilter extends Filters {

    protected $filters = ['imdb', 'genre', 'title'];

    public function imdb($value){

        if($value != "" || $value != null){
            return $this->builder->where(DB::raw("ROUND(`imdb_rating`) = $value"));
            // return $this->builder->orderBy('imdb_rating', 'DESC');
        }
    }

    public function genre($value){
        $array = explode(',', $value);

        if(!count($array)) return;

        return $this->builder->where(function($where) use ($array) {
            foreach($array as $index => $arr){
                $a = trim($arr);
                if($index == 0)
                    $where->whereRaw(DB::raw("FIND_IN_SET('$a', genres)"));
                else
                    $where->orWhereRaw(DB::raw("FIND_IN_SET('$a', genres)"));
            }
        });
    }

    public function title($value) {
        if($value != "" || $value != null){
            return $this->builder->where('name', 'LIKE', "%{$value}%");
        }
    }

}
