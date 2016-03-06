<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Movies extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idActor'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];


    public function getMoviesByActor($id){

        $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $ch = curl_init();
        $url ="http://api.themoviedb.org/3/person/".$id."/movie_credits?api_key=".$api_key_param;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,0
        );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $cast = $decoded["cast"];
        curl_close($ch);

        $dataArray = array( );
        for ($i=0; $i < sizeof($cast); $i++) { 
            $tmpMovies =$cast[$i]["original_title"];
            array_push($dataArray, $tmpMovies);
        }
         var_dump($dataArray);
         return $dataArray;

    }
}