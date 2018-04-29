
<?php
	/*
	This PHP document provides functionality support for the userlist page
	*/

	session_start();

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
			
			$searchresponse[$i] = $obj['results'][$i];
			
		}
		
		// Encode results back into JSON
		$searchresponse = json_encode($searchresponse);
		
		// Echo results back to front end
		echo $searchresponse;
	}




	// NEW IMPLEMENTATIONS BELOWW
	if(isset($_POST['addtolist']) && !empty($_POST['addtolist'])) {
		$idtoadd = mysqli_real_escape_string($conn, $_POST['addtolist']);
		$memberid = $_SESSION['memberid'];
		$willthiswork = addtolist($conn, $idtoadd, $tmdbapi, $memberid);
		
		echo $willthiswork;
	}

	function addtolist($conn, $movieid, $tmdbapi, $memberid){
		$obtaindata = file_get_contents('https://api.themoviedb.org/3/movie/' . $movieid .'?api_key=' . $tmdbapi . '&language=en-US');
		
		$obj = json_decode($obtaindata, true);
		
		$overview = $obj['overview'];
		$title = $obj['title'];
		$actors = obtain_actors($movieid, $tmdbapi);
		$yearreleased = $obj['release_date'];
		$poster = substr($obj['poster_path'], 1);
		
		$moviedataarray = array("movieID" => $movieid,
							"overview" => $overview,
							"title" => $title,
							"actors" => $actors,
							"year_released" => $yearreleased,
							//"date_added" => NULL,
							"poster" => $poster);
		
		// Are there existing values?
		$queryexisting = "SELECT planning FROM usermovielist WHERE memberid = $memberid";
		$queryexisting_output = mysqli_query($conn, $queryexisting);
		$queryexisting_result = mysqli_fetch_array( $queryexisting_output, MYSQLI_ASSOC );
			
		$planningstatus = $queryexisting_result['planning'];
		
		// If the list is empty
		if ($planningstatus == NULL || $planningstatus == null) {
			
			$completeplanningarray = array($moviedataarray);
			
			// Write first movie to DB
			$planningjson = json_encode($completeplanningarray, JSON_FORCE_OBJECT);
			
			// Prepared statement for SQL insert
			$initiallisting = $conn->prepare("UPDATE usermovielist SET planning=? WHERE memberid = ?");
			$initiallisting->bind_param("si", $planningjson, $memberid);
			
			if (!$initiallisting->execute()) {
				return mysqli_error($conn);
			} else {
				return addtorecent($poster, $conn);
				//return json_encode($moviedataarray);
			}
			
		} else {
			// Get existing movie records and append to it
			$obtainexisting = "SELECT * FROM usermovielist WHERE memberid = $memberid";
			$obtainexisting_output = mysqli_query($conn, $obtainexisting);
			
			// Convert DB JSON to associative array
			$obtainexisting_currplanning = mysqli_fetch_array($obtainexisting_output, MYSQLI_ASSOC);
			
			$obtainexisting_assocarray = json_decode($obtainexisting_currplanning['planning'], true);
			
			// Push new movie into store
			array_push($obtainexisting_assocarray, $moviedataarray);
			
			// Rewrite the value into database
			$reencoded = json_encode($obtainexisting_assocarray);
			
			// Prepared statement
			$subsequentlisting = $conn->prepare("UPDATE usermovielist SET planning = ? WHERE memberid = ?");
			$subsequentlisting->bind_param("si", $reencoded, $memberid);
			
			if (!$subsequentlisting->execute()) {
				return mysqli_error($conn);
			} else {
				$tests = addtorecent($poster, $conn);
				return $tests;
			}
		}
	}


	function obtain_actors($id, $tmdbapi){
		// Query TMDB API for actor data
		$actordata = 'https://api.themoviedb.org/3/movie/' . $id . '/credits?api_key=' . $tmdbapi;
		
		// Parsing results into associative array
		$actordata_raw = file_get_contents($actordata);
		$obj = json_decode($actordata_raw, true);
		
		// Variable to store string of actors
		$stringofactors = NULL;
		
		// If TMDB API did not return actors
		if (count($obj['cast']) < 1) {
			$stringofactors = "No actor information provided";
			return $stringofactors;
		}
		
		// Obtain up to 5 actors
		for ($i = 0; $i < count($obj['cast']); $i++){
			if ($i == 5){
				break;
			}
			
			// Concatenating actors
			if ($stringofactors == NULL) {
				$stringofactors = $obj['cast'][$i]['name'] . ', ';
			} else if ($i == 4) {
				$stringofactors = $stringofactors . $obj['cast'][$i]['name'];
			} else {
				$stringofactors = $stringofactors . $obj['cast'][$i]['name'] . ', ';
			}	
		}
		// Returns a string of actors from queried movie ID
		return $stringofactors;
	}
	

	function addtorecent($postercode, $conn){
		$recentquery = "SELECT * FROM appdatastore WHERE datapoint = 1";
		$recentquery_dbreturn = mysqli_query($conn, $recentquery);

		$row = mysqli_fetch_array($recentquery_dbreturn, MYSQLI_ASSOC);
		
		$arrayofposters = array();
		
		if ($row['appdata'] == NULL){
			// Initialise and add poster to the database
			array_push($arrayofposters, $postercode);
			
		} else {
			$arrayofposters = unserialize($row['appdata']);
			
			for ($i = 0; $i < count($arrayofposters); $i++){
				if ($postercode == $arrayofposters[$i]){
					return "Duplicatate detected";
				}
			}
			
			if (count($arrayofposters) == 20) {
				// Insert into rand posit TODO
				
				$arrayofposters[0] = $postercode;
			} else {
				array_push($arrayofposters, $postercode);
			}
		}
		
		$serializedposterarray = serialize($arrayofposters);
		
		// Write serialized array back to DB using prepared statements
		$writerecents = $conn->prepare("UPDATE appdatastore SET appdata = ? WHERE datapoint = 1");
		$writerecents->bind_param("s", $serializedposterarray);
		
		if (!$writerecents->execute()){
			return $serializedposterarray;
		} else {
			return $serializedposterarray;
		}
		
		//return mysqli_error($conn);
	}

?>