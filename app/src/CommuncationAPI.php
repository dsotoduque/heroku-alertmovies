<? php

	class CommunicationAPi (){

		public function getIdActorByName ()
		{
			 $api_key_param ="d8c7c3d90f2597cd3c2f24e1447954f3";
        $query_param = "bradley cooper";
        $query_param_process= urlencode($query_param);
           $url = "http://api.themoviedb.org/3/search/person?api_key=".$api_key_param."&&query=".$query_param;
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

        echo $id;
        curl_close($ch);
            return $id;
		}

		public function getMoviesByActor(){

			$api_key_param = "d8c7c3d90f2597cd3c2f24e1447954f3";
		$query_param_process= str_replace(" ","%20", $query_param);
		$id= 500;
		echo $query_param_process;
		



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
	#var_dump($cast);
	curl_close($ch);

	$dataArray = array( );
	for ($i=0; $i < sizeof($cast); $i++) { 
		$tmpMovies =$cast[$i]["original_title"];
		array_push($dataArray, $tmpMovies);
	}
	 return $dataArray;
		}










	}