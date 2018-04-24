
<?php
	/*
	This PHP document provides functionality support for the userlist page
	*/

	// Processing search from jQuery POST
	//$searchresponse = array();
//	if (isset($_POST['searchquery']) && !empty($_POST['searchquery'])){
//		// Return success message to jQuery
//		$searchresponse['type'] = "success";
//		
//		// Save query to a HTML friendly variable
//		$htmlfriendlyquery = rawurlencode($_POST['searchquery']);
//		
//		// Query API for results
//		$moviedata = file_get_contents('https://api.themoviedb.org/3/search/movie?api_key=' . $tmdbapi . '&language=en-US&query=' . $htmlfriendlyquery . '&page=1&include_adult=false');
//		
//		// Parsing results into associative array
//		$obj = json_decode($moviedata, true);
//		
//		// The results we want
//		// For each result returned by tMDB up to 6 results
//		for ($i = 0; $i < count($obj['results']) || $i < 7; $i++){
//			$searchresponse['tmdbresponse'][$i] = $obj['results'][$i];
//		}
//		$searchresponse = json_encode($searchresponse);
//		echo $searchresponse;
//		print_r($searchresponse);
//	} else {
//		$searchresponse['type'] = "error";
//		$searchresponse = json_encode($searchresponse);
//		echo $searchresponse;
//	}

	// Include essential credentials
	include(dirname(__FILE__).'../../../config/config.php');

	// When action POST received
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		// Save query to a HTML friendly variable to pass to TMDB API
		$htmlfriendlyquery = rawurlencode($_POST['action']);
    	
		// Query API for results
		$moviedata = file_get_contents('https://api.themoviedb.org/3/search/movie?api_key=' . $tmdbapi . '&language=en-US&query=' . $htmlfriendlyquery . '&page=1&include_adult=false');
		
		// Parsing results into associative array
		$obj = json_decode($moviedata, true);
		
		// The results we want: for each result returned by tMDB up to 6 results
		for ($i = 0; $i < count($obj['results']); $i++){
			if ($i == 8) {
				break;
			}
			
			// Obtain list of actors
			//$movieid = $obj['results'][$i]['id'];
			//$actors = obtain_actors($movieid, $tmdbapi);
			
			$searchresponse[$i] = $obj['results'][$i];
			
		}
		
		// Encode results back into JSON
		$searchresponse = json_encode($searchresponse);
		
		// Echo results back to front end
		echo $searchresponse;
		
	}

	function obtain_actors($id, $tmdbapi){
		// Query TMDB API for actor data
		$actordata = 'https://api.themoviedb.org/3/movie/' . $id . '/credits?api_key=' . $tmdbapi;
		
		// Parsing results into associative array
		$obj = json_decode($actordata, true);
		
		// Variable to store string of actors
		$stringofactors;
		
		// Obtain up to 5 actors
		for ($i = 0; i < count($obj['cast'][$i]); $i++){
			if ($i == 5){
				break;
			}
			
			// Concatenating actors
			$stringofactors = $stringofactors . $obj['cast'][$i]['name'] . ', ';
		}
		
		// Returns a string of actors from queried movie ID
		return $stringofactors;
	}
?>