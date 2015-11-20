 <?php
 class oauthCode{
	 public $apiKey; 
	 public $REDIRECT_URI; 
	 public function __construct($apiKey,$REDIRECT_URI) 
	 { 
		 $this->apiKey = $apiKey; 
		 $this->REDIRECT_URI = $REDIRECT_URI; 
		 $this->getCode(); 
	 } 
	 public function getCode() 
	 { 
		$auth_url = "https://oauth2.constantcontact.com/oauth2/oauth/siteowner/authorize?response_type=code&client_id=".$this->apiKey. "&redirect_uri=". urlencode($this->REDIRECT_URI); 
		header('Location: ' . $auth_url); 
	 } 
 }
 ?>