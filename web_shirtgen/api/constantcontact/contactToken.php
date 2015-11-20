

<?php

class GetToken{
	public $apiKey;
	public $apiSecret;
	public $authCode;
	
	 public function __construct($authCode,$apiKey,$apiSecret)
    {
        $this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		$this->authCode = $authCode;
        
    }
	public function getAccessToken($REDIRECT_URI)
    {
        $token_url = "https://oauth2.constantcontact.com/oauth2/oauth/token";
	
		$params = "code=" . $this->authCode
		. "&grant_type=authorization_code"
		. "&client_id=" . $this->apiKey
		. "&client_secret=" . $this->apiSecret
		. "&redirect_uri=" . urlencode($REDIRECT_URI);
		$curl = curl_init($token_url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ( $status != 200 ) {
			die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
			}
		curl_close($curl);
		$response = json_decode($json_response, true);
		return $response['access_token'];
    }


}
?>
