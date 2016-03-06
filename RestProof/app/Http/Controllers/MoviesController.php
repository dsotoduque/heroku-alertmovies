<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MoviesController extends Controller
{
	public  function findMovies($actorName){
     	$actor = self::getIdActorsByName($actorName);
     	$movies = self::getMoviesByActor($actor);

        header("Accept: application/json");

     	return response()->json([
     		"msg"=>"success",
     		"value" => $movies
     		]
     	);
    }

    public  function findDescription($movieName){
        $movie = self::getIdMoviesByName($movieName);
        $idMovie= $movie[0];
        $overview= $movie[1];
        $cast = self::descriptionMoviesActors($idMovie);

        header("Accept: application/json");

        return response()->json([
            "msg"=>"success",
            "id" => $idMovie,
            "overview" => $overview,
            "cast" => $cast
            ]
        );
    }

    public function findBiography($nameActor)
    {
        $actor = self::getIdActorsByName($nameActor);
        $biography = self::findBiographyByActorId($actor);
        header("Accept: application/json");
        return response()->json([
            "msg" => "success",
            "biography" => $biography[0],
            "birthday" => $biography[1],
            "popularity" => $biography[2]

            ]);

    }

    private function descriptionMoviesActors($idMovie){

     	$api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $ch = curl_init();
        $url ="http://api.themoviedb.org/3/movie/".$idMovie."/credits?api_key=".$api_key_param;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        "Accept: application/json"
        )
        );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $cast = $decoded["cast"];
        $dataArray= array();
        for ($i=0; $i < sizeof($cast); $i++) { 
            $tmpMovies =$cast[$i]["name"];
             array_push($dataArray, $tmpMovies);
        }
        
         #var_dump($dataArray);
        curl_close($ch);

        
         return $dataArray;

    }

     	
    

    public function getIdActorsByName($actorName){

        $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $query_param = $actorName;
        $query_param_process= urlencode($query_param);
           $url = "http://api.themoviedb.org/3/search/person?api_key=".$api_key_param."&&query=".$query_param_process;
           $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        "Accept: application/json"
        )
            );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $id = $decoded["results"][0]["id"];

        curl_close($ch);
            return $id;
        
    
}


     public function getMoviesByActor($id){

        $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $ch = curl_init();
        $url ="http://api.themoviedb.org/3/person/".$id."/movie_credits?api_key=".$api_key_param;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        "Accept: application/json"
        )
        );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $cast = $decoded["cast"];
        $dataArray= array();
        for ($i=0; $i < sizeof($cast); $i++) { 
            $tmpMovies =$cast[$i]["original_title"];
             array_push($dataArray, $tmpMovies);
        }
        
         #var_dump($dataArray);
        curl_close($ch);

        
         return $dataArray;

    }

    function getIdMoviesByName($movieName)
    {
        $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $query_param = $movieName;
        $query_param_process= urlencode($query_param);
           $url = "http://api.themoviedb.org/3/search/movie?api_key=".$api_key_param."&&query=".$query_param_process;
           $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        "Accept: application/json"
        )
            );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $id = $decoded["results"][0]["id"];
        $overview = $decoded["results"][0]["overview"];
        $array = array();
        array_push($array,$id);
        array_push($array, $overview);
        curl_close($ch);
            return $array; 
    	
    }


    public function findBiographyByActorId($id)
    {
         $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $ch = curl_init();
        $url ="http://api.themoviedb.org/3/person/".$id."?api_key=".$api_key_param;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        "Accept: application/json"
        )
        );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        //var_dump($decoded);
        $bio = $decoded["biography"];
        $birthday = $decoded["birthday"];
        $popularity = $decoded["popularity"];
        $arrayName = array();
        array_push($arrayName,$bio);
        array_push($arrayName,$birthday);
        array_push($arrayName,$popularity);
        curl_close($ch);

        
         return $arrayName;
    }
}
