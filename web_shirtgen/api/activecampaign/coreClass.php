<?php 
/* coreClassActiveCampaign */
class coreClassActiveCampaign{
	
	static public function apicerditialByUserId($params){
		$results = array();
		$results['url'] = $_SESSION['api_url'];
		return 	$results;		
	}
	static public function execute($params,$post){	
			$al_api_url = coreClassActiveCampaign::apicerditialByUserId($params);
			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');
			$url = rtrim($al_api_url['url'], '/ ');
			if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
			if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
				die('JSON not supported. (introduced in PHP 5.2.0)');
			}
			$api = $url . '/admin/api.php?' . $query;
			$request = curl_init($api); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($request); // execute curl post and store results in $response
			curl_close($request); // close curl object
			if ( !$response ) {
				die('Nothing was returned. Do you have a connection to Email Marketing server?');
			}
			$result = unserialize($response);
			$alResults['campaignId'] = $result['id'];			
			return $alResults;
			/* 
			echo 'Result: ' . ( $result['result_code'] ? 'SUCCESS' : 'FAILED' ) . '<br />';
			echo 'Message: ' . $result['result_message'] . '<br />';
			echo 'The entire result printed out:<br />';
			
			echo 'Raw response printed out:<br />';
			echo '<pre>';
			print_r($response);
			echo '</pre>';
			echo 'API URL that returned the result:<br />';
			echo $api;
			echo '<br /><br />POST params:<br />';
			echo '<pre>';
			print_r($post);
			echo '</pre>';	 
			*/ 	
	}
	static public function delete_execute($params){
		$al_api_url = coreClassActiveCampaign::apicerditialByUserId($params);
		$query = "";
		foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');		
		$url = rtrim($al_api_url['url'], '/ ');		
		if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
		if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}
		$api = $url . '/admin/api.php?' . $query;
		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		$response = (string)curl_exec($request); // execute curl fetch and store results in $response
		curl_close($request); // close curl object
		if ( !$response ) {
			die('Nothing was returned. Do you have a connection to Email Marketing server?');
		}
		$result = unserialize($response);
	}
	static public function compute($params,$url){	
				$query = "";
				foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
				$query = rtrim($query, '& ');
				$url = rtrim($url, '/ ');
				if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
				if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
					die('JSON not supported. (introduced in PHP 5.2.0)');
				}
				$api = $url . '/admin/api.php?' . $query;
				$request = curl_init($api); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
				$response = (string)curl_exec($request); // execute curl fetch and store results in $response
				curl_close($request); // close curl object
				if ( !$response ) {
					//die('Nothing was returned. Do you have a connection to Email Marketing server?');
					echo ('Nothing was returned. Do you have a connection to Email Marketing server?');
					mail('lenin@abacies.com','Nothing was returned','Nothing was returned');
				}
				if($response){
				$result = unserialize($response);
				return $result;					
				}
	}	
	
}
?>