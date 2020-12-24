<?php
    if ($_POST) {
        $data           = $_POST['data'];
        $result         = $_POST['result'];
        $db_user_info   = new Users();
        $oauth_provider = 'twitter';
        //Retrieve user info
        $oauth_token 		= $_SESSION['request_vars']['oauth_token'];
		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
		$connection			= new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
		$user_info 			= $connection->get('account/verify_credentials');
        $twitter_id			= $user_info->id;

        $status = $db_user_info->updatePrediction($oauth_provider, $twitter_id, $data, $result);
        if ($status) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }

?>