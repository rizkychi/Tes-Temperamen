<?php
class Users {
	public $tableName = 'users';
	
	function __construct(){
		//Database configuration
		$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'masrizky_testra'; //Define database username
		$dbPassword = 'gampang123'; //Define database password
		$dbName = 'masrizky_testra'; //Define database name
		
		//Connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$username,$fname,$lname,$locale,$oauth_token,$oauth_secret,$profile_image_url){
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0){
			$update = mysqli_query($this->connect,"UPDATE $this->tableName SET username = '".$username."', oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}else{
			$insert = mysqli_query($this->connect,"INSERT INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', username = '".$username."', fname = '".$fname."', lname = '".$lname."', locale = '".$locale."', oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', picture = '".$profile_image_url."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
			$inserted_id = mysqli_insert_id($this->connect);
			$insertPersonality = mysqli_query($this->connect,"INSERT INTO personality SET users_id =  ".$inserted_id.", created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
			$insertPrediction_result = mysqli_query($this->connect,"INSERT INTO prediction_results SET users_id =  ".$inserted_id) or die(mysqli_error($this->connect));
			$insertPrediction_type = mysqli_query($this->connect,"INSERT INTO prediction_type SET users_id =  ".$inserted_id) or die(mysqli_error($this->connect));
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}

	function updatePersonality($oauth_provider, $oauth_uid, $traits, $sanguine, $choleric, $melancholy, $phlegmatic, $primary_result, $secondary_result, $timer, $tweet, $protected){
		$update_person = mysqli_query($this->connect,"UPDATE personality p JOIN users u ON u.id = p.users_id SET p.traits = '".$traits."', p.sanguine = '".$sanguine."', p.choleric = '".$choleric."', p.melancholy = '".$melancholy."', p.phlegmatic = '".$phlegmatic."', p.primary_result = '".$primary_result."', p.secondary_result = '".$secondary_result."', p.timer = '".$timer."', p.tweet = '".$tweet."', p.protected = '".$protected."', p.modified = '".date("Y-m-d H:i:s")."' WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		//return true;
		$this->updateType($oauth_provider, $oauth_uid, 'test');
	}

	function updatePrediction($oauth_provider, $oauth_uid, $data, $result){
		$state = false;
		$update_person = mysqli_query($this->connect,"UPDATE prediction_results p JOIN users u ON u.id = p.users_id SET p.data = '".$data."', p.result = '".$result."', p.predict_date = '".date("Y-m-d H:i:s")."' WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if ($update_person) {
			$this->updateType($oauth_provider, $oauth_uid, 'auto');
			$state = true;
		} 
		return $state;
	}

	function updateType($oauth_provider, $oauth_uid, $type) {
		$update_type = mysqli_query($this->connect,"UPDATE prediction_type p JOIN users u ON u.id = p.users_id SET p.type = '".$type."' WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
	}

	function retakePredict($oauth_provider, $oauth_uid) {
		$retake_predict = mysqli_query($this->connect,"UPDATE prediction_type p JOIN users u ON u.id = p.users_id SET p.type = null WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
	}

	function getPredictType($oauth_provider, $oauth_uid) {
		$query = mysqli_query($this->connect,"SELECT p.type FROM prediction_type p JOIN users u ON u.id = p.users_id WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_assoc($query);
		return $result['type'];
	}

	function getUserInfo($oauth_provider, $oauth_uid, $type){
		$query = "";
		if ($type == 'test') {
			$query = mysqli_query($this->connect,"SELECT p.primary_result AS result FROM personality p JOIN users u ON u.id = p.users_id WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		} else if ($type == 'auto') {
			$query = mysqli_query($this->connect,"SELECT p.result FROM prediction_results p JOIN users u ON u.id = p.users_id WHERE u.oauth_provider = '".$oauth_provider."' AND u.oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}
		$result = mysqli_fetch_assoc($query);
		return $result['result'];
	}
	
	function getListWinnerGA() {
		$query = mysqli_query($this->connect,"SELECT u.username FROM personality p join users u on p.users_id = u.id where tweet >= 200 and p.modified < '2020-08-31 00:00:00' and u.id > 2") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_all($query);
		return $result;
	}
	
}
?>