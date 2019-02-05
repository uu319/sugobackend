<?php

// require "../model/Model.php";

date_default_timezone_set('Asia/Manila');

function getMatchErunner($id){
	$start = startMatchErunner($id);
	// while($return['error'] == true){
	// 	getMatchErunner($id);
	// }
	while($start['error'] == true){
		$restart = startMatchErunner($id);
		echo json_encode($restart);
		echo "again";
	}
}

function startMatchErunner($id){
	$return = array();
	$distance = array();
	$errand_array = array();

	// $id = $_POST['errand_id'];
	$model = new Model();
	$getErrand = $model->getErrandById($id);
	foreach($getErrand as $gt){ $option_id = $gt['option_id']; }
	$result = $model->getAvailableErunner($option_id);
	// var_dump($getErrand);
	if(count($getErrand) > 0){
		//get all active and available erunners
		foreach($result as $res){
			//get location of erunners
			$latlong = explode(',', $res['current_location']);
			if(!isset($latlong[1])){
				$latlong[1] = null;
			}
			$erunnerlat = $latlong[0];
			$erunnerlong[$latlong[1]] = $latlong[1];
			$erunnerLatlong = array('erunner_username'=>$res['username'], 'erunner_latitude'=>$erunnerlat, 'erunner_longitude'=>$erunnerlong[$latlong[1]]);

			array_push($errand_array, $erunnerLatlong);
		}

		foreach($getErrand as $errand){
			//get location of errands
	    	$latlong2 = explode(',', $errand['location']);
	    	if(!isset($latlong2[1])){
	    		$latlong2[1] = null;
	    	}
	    	$errandlat =  $latlong2[0];
	    	$errandlong[$latlong2[1]] = $latlong2[1];
	    	$errandLatlong = array('errand_id'=>$errand['errand_id'], 'errand_latitude'=>$errandlat, 'errand_longitude'=>$errandlong[$latlong2[1]]);

	    	$distance = distance($errand['errand_id'], $errandlat, $errandlong[$latlong2[1]], $errand_array);
	    	// array_push($distance, distance($errand['errand_id'], $errandlat, $errandlong[$latlong2[1]], $erunnerLatlong));
			// array_push($distance, distance($res['username'], $errandlat, $errandlong[$latlong2[1]], $errand['errand_id'], $erunnerlat, $erunnerlong[$latlong[1]], "K"));

		}

		// var_dump($distance);
		if(empty($distance)){
			$return ['msg'] = "No match found";
		    $return ['error'] = true;
		    $return ['errand_id'] = $id;
		}
		else{
		// foreach($distance as $d){
			foreach($distance as $dd){
				$dist[] = $dd['distance'];
			}
		// }
		$nearest = min($dist);
		// var_dump($nearest);
		// foreach($distance as $d2){
			foreach($distance as $dd2){
				if($dd2['distance'] == $nearest){
					$data = $dd2;
				}
			}
		// }

			// var_dump($data);
			if(count($data) > 0){

				// foreach($data as $da){
					$erunner_username = $data['erunner_username'];
				// }
				$model = new Model();
				// $result2 = $model->checkErunnerCurrentErrand($erunner_username);
				$result2 = $model->checkErunerStatus($erunner_username);
				// var_dump($result2); exit();
				if(count($result2) > 0){
					// $result3 = $model->getAvailableErunner();
					// var_dump($result3);
					// getErunnerExcept($id, $result3);
					$return ['msg'] = 'No suitable match found';
				    $return ['error'] = true;
				    $return ['errand_id'] = $id;
				}
				else{
					$return ['msg'] = $data;
		    		$return ['error'] = false;
		    		$updateErrand = $model->updateMatchErrand($data['erunner_username'], $data['errand_id']);
		    		$updateErunnerStatus = $model->updateErunnerStatus($data['erunner_username']);
		    		// var_dump($updateErrand);
		    		if($updateErrand == 0 && $updateErunnerStatus==0){
		    			$optionName = $model->getUserErrandsByErrandId($errand['errand_id']);
		    			foreach($optionName as $op){
		    			$description = "You have an errand match - ".$op['option_name']." errand";
							$toNofification = $model->toNofification($data['erunner_username'], $description, date('Y-m-d H:i:s'), $errand['errand_id']);
							}

						$gettoken = $model->getTokenByUsername($data['erunner_username']);
						foreach($gettoken as $token){
						$mytoken = $token['token'];
						}
		    			if($toNofification){
		    				echo "OK";
		    			}else {
								echo "FAILED";
							}
							// require_once __DIR__ . '/notification.php';
							// $notification = new Notification();
							// $notification->setTitle("You have a new errand");
							// $notification->setMessage("This is a notification from getMatchErunner");
							// $notification->setImage("url");
							// $notification->setAction("sample action");
							// $notification->setActionDestination("Sample Destination");

							// $notification->setBody("This is a body from getMatchErrand");
							// $notification->setText("This is a texy from getMatchErrand");
							// $notification->setClickAction("MainActivity");
							// $requestData = $notification->getDataPayload();
							// $requestNotification= $notification->getNotification();
							// $fields = array(
							// 	'to' => $mytoken,
							// 	'data' => $requestData,
							// 	'notification'=>$requestNotification,
							// );
							// $notification->setFields($fields);
							// $notification->notifHandler();
							// $return['token']=$requestData;
							// $return['fields']= $fields;
		    		}
				}
			}
			else{
				$return ['msg'] = 'No match found';
			    $return ['error'] = true;
			    $return ['errand_id'] = $id;
			}
		}


	}
	else{
	    $return ['msg'] = 'Errand is unavailable to match';
	    $return ['error'] = true;
	    $return ['errand_id'] = $id;
	}

	// return json_encode($return);
	return $return;
}






function distance($errand_id, $errand_latitude, $errand_longitude, $runner){
// function distance($erunner, $lat1, $lon1, $errand_id, $lat2, $lon2, $unit) {
	$all_distance = array();

	$unit = "K";
	$lat1 = $errand_latitude;
	$lon1 = $errand_longitude;
	// var_dump($errand);
	foreach($runner as $err){
		$erunner = $err['erunner_username'];
		$lat2 = $err['erunner_latitude'];
		$lon2 = $err['erunner_longitude'];

		$theta = $lon1 - $lon2;
	  	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  	$dist = acos($dist);
	  	$dist = rad2deg($dist);
	  	$miles = $dist * 60 * 1.1515;
	  	$unit = strtoupper($unit);

	  	if ($unit == "K") {
	  		$distance_km = number_format((float)$miles * 1.609344, 2);
	      	array_push($all_distance, array('erunner_username'=>$erunner, 'distance'=>$distance_km, 'errand_id'=>$errand_id));
	  	} else if ($unit == "N") {
	      	return ($miles * 0.8684);
	  	} else {
	      	return $miles;
  		}
	}return $all_distance;

}
?>



function getAvailableErunner($id){
        $query = $this->db->query("SELECT * FROM user LEFT JOIN services_offered ON user.username = services_offered.erunner_username WHERE type = ? AND status = ? AND services_offered.option_id = ?", array('erunner', 'active', $id), "SELECT");
        return $query;
    }