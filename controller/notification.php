<?php
class Notification{

	private $title;
	private $message;
	private $image_url;
	private $action;
	private $action_destination;
	private $data;
  private $text;
  private $body;
  private $click_action;
	private $token;
	private $fields;



	function __construct(){

	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function setImage($imageUrl){
		$this->image_url = $imageUrl;
	}

	public function setAction($action){
		$this->action = $action;
	}

	public function setActionDestination($actionDestination){
		$this->action_destination = $actionDestination;
	}

	public function setPayload($data){
		$this->data = $data;
	}

  public function setText($text){
    $this->text=$text;
  }
  public function setBody($body){
    $this->body= $body;
  }

  public function setClickAction($click_action){
    $this->click_action= $click_action;
  }
	public function setToken($token){
    $this->token= $token;
  }
	public function setFields($fields){
		  $this->fields= $fields;
	}

	public function getFields(){
		return $this->fields;
	}

  public function getNotification(){
    $notification = array();
    $notification['text'] = $this->text;
		$notification['title'] = $this->title;
    $notification['body'] = $this->body;
    $notification['click_action'] = $this->click_action;
    return $notification;
  }

	public function getDataPayload(){
		$notification = array();
		$notification['message'] = $this->message;
		$notification['action'] = $this->action;
		$notification['image'] = $this->image_url;
		$notification['action_destination'] = $this->action_destination;
		return $notification;
	}


	public function notifHandler(){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$firebase_api = "AAAAG3DrL0s:APA91bGwallUJL2HxPkQbCdKoi4E9_OOpW6y1KK4TE63Ce1VPo8wERG2Iyv4cAd_I_sqwRjdgSvkRKIdZqU8Dw32rrt9YCjtbEmfsXhwOCXg-v0zcFzQ1QOP5-RBRwGKnSDBC6RfdfzM";
		$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
		);
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarily
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->fields));
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE){
			// die('Curl failed: ' . curl_error($ch));
			echo "Error";
		}else{
		echo json_encode($this->fields);
		}
		 // Close connection
		curl_close($ch);
}
}
?>
