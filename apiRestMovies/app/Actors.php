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
        'nameActor'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];


   public  function getIdActorsByName($nameActor){

        $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $query_param = $nameActor;
         $query_param_process= urlencode($query_param);
           $url = "http://api.themoviedb.org/3/search/person?api_key=".$api_key_param."&&query=".$query_param;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER,0
            );

        $response = curl_exec($ch);
        $decoded = json_decode($response, true);
        $id = $decoded["results"][0]["id"];

        echo $id;
        curl_close($ch);
            return $id;
        
    
}


}
