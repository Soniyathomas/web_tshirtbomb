<?php 
session_start();
require_once 'connect.php';
require_once 'fbphp5/src/Facebook/autoload.php';
$siteUrl_2	=	$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'];
$siteurl	=	'https://wpmonk.herokuapp.com/';
$recid = $_REQUEST["CId"];
$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data + 1;	
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();	
			}
//facebook_campaign start
$fc_params['id'] = $_REQUEST["CId"];
$fc_params['meta_key'] = 'facebook_campaign';
$fc_appMeta = campaign::getCampaignMetaValueByCampaignId($fc_params);
$fcId = $fc_appMeta['meta_value'];
//facebook_campaign end
$t_params['id'] = $fcId;
$t_params['meta_key'] = 'app_token';
$t_appMeta = campaign::getCampaignMetaValueByCampaignId($t_params);
$token = $t_appMeta['meta_value'];
$_SESSION['al_token'] = $token;
//token 
//token 
$appid_params['id'] = $fcId;
$appid_params['meta_key'] = 'app_id';
$appid_appMeta = campaign::getCampaignMetaValueByCampaignId($appid_params);
$appid = $appid_appMeta['meta_value'];
$_SESSION['al_appid'] = $appid;
//token 
//app_secret_id
$app_secret_id_params['id'] = $fcId;
$app_secret_id_params['meta_key'] = 'app_secret_id';
$app_secret_id_appMeta = campaign::getCampaignMetaValueByCampaignId($app_secret_id_params);
$app_secret_id = $app_secret_id_appMeta['meta_value'];
$_SESSION['al_app_secret_id'] = $app_secret_id;
//app_secret_id 	

foreach ($_COOKIE as $k=>$v) {
    if(strpos($k, "FBRLH_")!==FALSE) {
        $_SESSION[$k]=$v;
    }
}
$fb = new Facebook\Facebook([
	  'app_id' => $appid,
	  'app_secret' => $app_secret_id,
	  'default_graph_version' => 'v2.2',
	  ]);
$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  //go to failer url 
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  //go to failer url   
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
														  
     header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n"; 
	
	//clicks counter start
	
				$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();				
			}

	//clicks counter end		
	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'curl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];		
	if($redirection){
		//header("Location:$redirection");			
		header("Location:$siteUrl_2/fbscript_cancel.php?CId=$recid&mId=$mId&tid=$tId&level=4");	
	} else {
		header("Location:http://teespring.com");		
	}	
  //go to failer url 	 
  } else {													  	  
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
	/*
	//clicks counter start
				$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();	
				//gomail('lenin@abacies.com','Cancel_2_CLicks-->'.$mId.'',print_r($clicks_campaignMeta_data,true));												
			}
	//clicks counter end		
	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'curl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];		
	if($redirection){
		//header("Location:$redirection");			
		header("Location:$siteUrl_2/fbscript_cancel.php?CId=$recid&tid=$tId&level=4");	
	} else {
		header("Location:$siteUrl_2?page=nourlgiven&fbEmailidNoPermission=1");		
	}	
  //go to failer url 
	*/  
  }
  exit;
}

// Logged in
/*
echo '<h3>Access Token</h3>';
echo "<pre>";
print_r($accessToken->getValue());
echo "</pre>";
*/
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// Validation (these will throw FacebookSDKException's when they fail)
$config['app_id'] = $appid;
$tokenMetadata->validateAppId($config['app_id']);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();
$_SESSION['fb_access_token'] = (string) $accessToken;
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,email,name,first_name,last_name,gender,link,locale,verified', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  //go to failer url   
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  //go to failer url   
  exit;
}
$userdata = $response->getGraphUser();

$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data + 1;	
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();
				//gomail('lenin@abacies.com','CLicks-->'.$mId.'',print_r($clicks_campaignMeta_data,true));				
			}

	if($userdata){		
	$database = new Database();
	$database->query('SELECT * FROM  heroku_fb_users WHERE  email = :email AND campaignId = :campaignId AND status = :status');
	$database->bind(':email', $userdata['email']);
	$database->bind(':campaignId', $_REQUEST["CId"]);	
	$database->bind(':status', '1');		
	$rows = $database->resultset();	

//checking clicks	
		$mId = $_REQUEST["mId"];
	if($mId){
	$database = new Database();
		$campaign_dclicks['id'] = $mId;
		$campaign_dclicks['meta_key'] = 'dclicks';
		$campaign_dclicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_dclicks);											
		$dclicks_campaignMeta_data = ($campaign_dclicks_Meta['meta_value'])? $campaign_dclicks_Meta['meta_value'] : 0 ;
		$dclicks_count = $dclicks_campaignMeta_data + 1;	
		$sql_dclicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
		$database->query($sql_dclicks);				
		$database->bind(':updateId', $mId);
		$database->bind(':meta_key', 'dclicks');		
		$database->bind(':updateValue', $dclicks_count);		
		$database->execute();	
	}
	
//checking clicks		
	
	if(empty($rows)){
		if(empty($userdata["email"])){
			//clicks counter start
			$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;

				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();

			}
			//clicks counter end			
			header("Location:$siteUrl_2?page=customPageGoesHere&noEmailAccessbutappaccepted");				
			exit;
		} else {
		
		$databaseemail = new Database();
		$sqlemail = "SELECT meta_value FROM heroku_campaign_meta where campaignId = :campaignId AND meta_key = :meta_key";
		$databaseemail->query($sqlemail);
		$databaseemail->bind(':campaignId', $_REQUEST["CId"]);
		$databaseemail->bind(':meta_key', $_REQUEST["mId"]);		
		$resultsemail = $databaseemail->single();
		if($resultsemail['meta_value'] == 1)
		{
		$emailstatus = 1;
		}else{
		$emailstatus = 4;
		}
		//insert 
			///////////////////////////////////////////////////
	$sql_insert = "INSERT INTO heroku_fb_users (fbid, campaignId, email, name, first_name, last_name, gender, link, locale, verified, status, create_date, last_update) 
	VALUES 
	(:fbid,:campaignId,:email,:name,:first_name,:last_name,:gender,:link,:locale,:verified,:status,:create_date,:last_update);";			
	$database->query($sql_insert);				
	$database->bind(':fbid', $userdata["id"]);
	$database->bind(':campaignId', $_REQUEST["CId"]);	
	$database->bind(':email', $userdata["email"]);	
	$database->bind(':name', $userdata["name"]);	
	$database->bind(':first_name', $userdata["first_name"]);	
	$database->bind(':last_name', $userdata["last_name"]);	
	$database->bind(':gender', $userdata["gender"]);	
	$database->bind(':link', $userdata["link"]);	
	$database->bind(':locale', $userdata["locale"]);	
	$database->bind(':verified', $userdata["verified"]);	
	$database->bind(':status', $emailstatus);	//4 is inactive, 1 is active
	$database->bind(':create_date', date('Y-m-d H:i:s'));	
	$database->bind(':last_update', date('Y-m-d'));		
	$database->execute();
	//last inserted id start	
	$database_last = new Database(); 
	$sqllastInsertedId = "SELECT * FROM heroku_fb_users where campaignid = ".$_REQUEST["CId"]." ORDER BY id DESC;";	
	$database_last->query($sqllastInsertedId);	
	$database_last_row = $database_last->single();
	$lastInserted_contact = ($database_last_row['id'])?$database_last_row['id']:0;	
	
	
	// tracking campaign and only convertion start
	
	//clicks counter start
$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();
				
			}
	//clicks counter end	
	//conversions counter start
	$mId = $_REQUEST["mId"];
	if($mId){
	$database = new Database();
		$campaign_conversions['id'] = $mId;
		$campaign_conversions['meta_key'] = 'conversions';
		$campaign_conversions_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_conversions);											
		$conversions_campaignMeta_data = ($campaign_conversions_Meta['meta_value'])? $campaign_conversions_Meta['meta_value'] : 0 ;
		$conversions_count = $conversions_campaignMeta_data + 1;	
		$sql_conversions = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
		$database->query($sql_conversions);				
		$database->bind(':updateId', $mId);
		$database->bind(':meta_key', 'conversions');		
		$database->bind(':updateValue', $conversions_count);		
		$database->execute();	
	}	
	//conversions counter end		
	
	//last inserted id end
	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'surl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];	
	
	/* check source from api==1 or form==2 */
	$sourceform['id'] = $_REQUEST["CId"];
	$sourceform['meta_key'] = 'radioValue';
	$sourceformcampaignMeta = campaign::getCampaignMetaValueByCampaignId($sourceform);
	$sourceformcampaignMetadata = $sourceformcampaignMeta['meta_value'];	
	/* check source from api==1 or form==2 */		
	if($sourceformcampaignMetadata==2){ 
	$htmlform['id'] = $_REQUEST["CId"];
	$htmlform['meta_key'] = 'autoresponder';
	$htmlformcampaignMeta = campaign::getCampaignMetaValueByCampaignId($htmlform);											
	$htmlformcampaignMetadata = $htmlformcampaignMeta['meta_value'];		
	}


	
	if(empty($htmlformcampaignMetadata)){
	//if(false){		
			$camp_campaign_params['id'] =  $_GET["CId"];
			$camp_campaign_params['meta_key'] = 'camplistapp_campaign';
			$camp_campaignMeta = campaign::getCampaignTrackingIdByCampaignId($camp_campaign_params);	
			$campaign_mode = substr($camp_campaignMeta[0]['meta_value'],0,1);														
			///111 
			if($campaign_mode==1){
			

			//active campaign start 
			//camp_api_url 												
			$al_key = $camp_campaignMeta[0]['meta_value'];
			$t_params['id'] = $al_key;
			$t_params['meta_key'] = 'camp_api_url';												
			$apiurl_value = campaign::getCampaignMetaValueByCampaignId($t_params);
			//camp_api_url 			
			//camp_api_key 
			$appid_params['id'] = $al_key;
			$appid_params['meta_key'] = 'camp_api_key';
			$apikey_value = campaign::getCampaignMetaValueByCampaignId($appid_params);
			//camp_api_key 				
			///111 			
		//start api add contact
			$url = $apiurl_value['meta_value'];
			if($url!='' && $apikey_value['meta_value']!='') {				
			$params = array(
				'api_key'      => $apikey_value['meta_value'],
				'api_action'   => 'contact_add',
				'api_output'   => 'serialize',
			);
		$campaign_listId['id'] = $_REQUEST['CId'];
		$campaign_listId['meta_key'] = 'heroapp_api_list_join';
		$campaign_listId_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_listId);											
		$listId = ($campaign_listId_Meta['meta_value'])? $campaign_listId_Meta['meta_value'] : 0 ;
			$post = array(
				'email'                    => $userdata["email"],
				'first_name'               => $userdata["first_name"],
				'last_name'                => $userdata["last_name"],
				'tags'                     => 'api',
				'p['.$listId.']'                   => $listId, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
				'status['.$listId.']'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
				// use the folowing only if status=1
				'instantresponders['.$listId.']' => 1, // set to 0 to if you don't want to sent instant autoresponders
			);
			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');
			// clean up the url
			$url = rtrim($url, '/ ');
			if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
			if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
				die('JSON not supported. (introduced in PHP 5.2.0)');
			}
			$api = $url . '/admin/api.php?' . $query;
			$request = curl_init($api); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($request); // execute curl post and store results in $response
			curl_close($request); // close curl object
			if ( !$response ) {
				die('Nothing was returned. Do you have a connection to Email Marketing server?');
			}
			$result = unserialize($response);
			$alSubscriberId = ($result['subscriber_id'])?$result['subscriber_id']:0;
			$database = new Database();			
			$sql_tracking_clicks = "INSERT INTO heroku_campaign_meta (campaignId, meta_key, meta_value) VALUES (:campaignId, :meta_key, :meta_value);";	
			$database->query($sql_tracking_clicks);				
			$database->bind(':campaignId', $lastInserted_contact);
			$database->bind(':meta_key', 'api_subscriberId');	
			$database->bind(':meta_value',$alSubscriberId );		
			$database->execute();
			}			
		//end api add contact 
			//active campaign end
		}	
		if($campaign_mode==2){	
		
			/* $actual_link = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."";
			if(empty($_REQUEST['aweber_al'])){
			?>
			<script>			
			window.location.href = '<?=$actual_link?>&aweber_al=true';
			</script>
			<?php 
			} */
			$al_rkey = $campaign_mode;
			$get_aapt['id'] =  $al_rkey.$_REQUEST['tId'];
			$get_aapt['meta_key'] = 'aweber_access_api_token';
			$get_aapt_meta = campaign::getCampaignMetaValueByCampaignId($get_aapt);
			$get_aats['id'] =  $al_rkey.$_REQUEST['tId'];
			$get_aats['meta_key'] = 'aweber_access_api_token_secret';
			$get_aats_meta = campaign::getCampaignMetaValueByCampaignId($get_aats);						
			$acctoken = $get_aapt_meta['meta_value'];
			$acctieken_secret = $get_aats_meta['meta_value'];						
			
			$get_cu['id'] =  $al_rkey.$_REQUEST['tId'];
			$get_cu['meta_key'] = 'camp_api_url';
			$get_cu_meta = campaign::getCampaignMetaValueByCampaignId($get_cu);		
			$get_ck['id'] =  $al_rkey.$_REQUEST['tId'];
			$get_ck['meta_key'] = 'camp_api_key';
			$get_ck_meta = campaign::getCampaignMetaValueByCampaignId($get_ck);					
			$consumerKey = $get_ck_meta['meta_value']; # Put your consumer key here
			$consumerSecret = $get_cu_meta['meta_value']; # Put your consumer secret key here		
			
			//$aweber = new AWeberAPI($consumerKey, $consumerSecret);				
			
			//$account = $aweber->getAccount($acctoken, $acctieken_secret);
			//$account_id = $account->id;				
			$aweber_join_params['id'] =  $_GET["CId"];			
			$aweber_join_params['meta_key'] = 'heroapp_api_aweber_join';
			$aweber_api_camp_join = campaign::getCampaignTrackingIdByCampaignId($aweber_join_params);			
			$list_id = $aweber_api_camp_join[0]['meta_value']; // Enter list Id here
			$listUrl = "/accounts/".$account_id."/lists/".$list_id."";			
			//$list=$account->loadFromUrl($listURL);
			# create a subscriber
			/*
			$aweber_params = array(
			'email' => $userdata["email"],
			'name' => $userdata["first_name"]
			);			
			*/
			$aweberEmailId = $userdata["email"];
			$aweberName = $userdata["first_name"];
			$alaweberUrl = "https://shirtgen.herokuapp.com/api/aweber/aweberAddSubscriber.php";
			$alexecute_1 = "?email=$aweberEmailId&name=$aweberName&consumerKey=$consumerKey&consumerSecret=$consumerSecret&accessTokenSecret=$acctieken_secret&accessToken=$acctoken&list_id=$list_id";
			$alfinalurl =  	$alaweberUrl.$alexecute_1;
			file_get_contents($alfinalurl);
////////////Mail function ///////////
				require 'email/PHPMailerAutoload.php';
				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'postmaster@app3f1d450adc714f51be6a0db92bb2c1b4.mailgun.org';   // SMTP username
				$mail->Password = 'dd007fac3fcf5b5c3543b1647908711f';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

				$mail->From = 'info@wpmonks.com';
				$mail->FromName = 'wpmonk api';
				$mail->addAddress('lenin@abacies.com');                 // Add a recipient
				
				//$mail->WordWrap = 50;                                // Set word wrap to 50 characters

				$mail->Subject = 'WPMONKS API';
				$mail->Body    = print_r($alfinalurl,true);
				$mail->AltBody = print_r($alfinalurl,true);
				if(!$mail->send()) 
				{
				   $msg= 'Message could not be sent.';
				   $msg.= 'Mailer Error: ' . $mail->ErrorInfo;
				} else 
				{
				   $msg= 'Message has been sent';
				} 
////////////mail Function ////////////			
			/*
			$aweber_params = array(
			'email' => 'lenin2ud@gmail.com',
			'name' => 'lenin2ud'
			);			
			$subscribers = $list->subscribers;
			$new_subscriber = $subscribers->create($aweber_params);						
			*/
			//$new_subscriber = AWeberCollection::alcreate($aweber_params);									
			
			
		}
		//get response start
		if($campaign_mode==3){
			
			/* $actual_link = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."";
			if(empty($_REQUEST['get_response'])){
			?>
			<script>			
			window.location.href = '<?=$actual_link?>&get_response=true';
			</script>
			<?php 
			} */
			$camp_campaign_params['id'] =  $_GET["CId"];
			$camp_campaign_params['meta_key'] = 'camplistapp_campaign';
			$camp_campaignMeta = campaign::getCampaignTrackingIdByCampaignId($camp_campaign_params);	
			$campaign_mode = substr($camp_campaignMeta[0]['meta_value'],0,1);																	
			
			$gr_join_params['id'] =  $_GET["CId"];
			$gr_join_params['meta_key'] = 'heroapp_api_getresponse_list_join';
			$gr_api_camp_join = campaign::getCampaignTrackingIdByCampaignId($gr_join_params);													
			//camp_api_url 												
			$al_key = $camp_campaignMeta[0]['meta_value'];
			$t_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$t_params['meta_key'] = 'camp_api_url';												
			$t_appMeta = campaign::getCampaignMetaValueByCampaignId($t_params);
			$camp_api_url = $t_appMeta['meta_value'];
			//camp_api_url 			
			//camp_api_key 
			$appid_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$appid_params['meta_key'] = 'camp_api_key';
			$appid_appMeta = campaign::getCampaignMetaValueByCampaignId($appid_params);
			$camp_api_key = $appid_appMeta['meta_value'];
			//camp_api_key 	
////////////Mail function ///////////
				require 'email/PHPMailerAutoload.php';
				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'postmaster@app3f1d450adc714f51be6a0db92bb2c1b4.mailgun.org';   // SMTP username
				$mail->Password = 'dd007fac3fcf5b5c3543b1647908711f';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

				$mail->From = 'info@wpmonks.com';
				$mail->FromName = 'wpmonk getResponse api';
				$mail->addAddress('lenin@abacies.com');                 // Add a recipient
				
				//$mail->WordWrap = 50;                                // Set word wrap to 50 characters

				$mail->Subject = 'WPMONKS GET Response API';
				$mail->Body    = print_r($camp_api_key,true);
				$mail->AltBody = print_r($camp_api_key,true);
				if(!$mail->send()) 
				{
				   $msg= 'Message could not be sent.';
				   $msg.= 'Mailer Error: ' . $mail->ErrorInfo;
				} else 
				{
				   $msg= 'Message has been sent';
				} 
////////////mail Function ////////////			
			// start of get response			
			$api = new GetResponseAPI($camp_api_key);																					
			// end of get response			
			$ac = $api->addContact($gr_api_camp_join[0]['meta_value'], $userdata["first_name"],$userdata["email"]);						
		}
		//get response end	
		//mailchimp start
		if($campaign_mode==4){
			/* $actual_link = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."";
			if(empty($_REQUEST['mailchimp'])){
			
			?>
			<script>			
			window.location.href = '<?=$actual_link?>&mailchimp=true';
			</script>
			<?php 
			} */
			
			$mc_join_params['id'] =  $_GET["CId"];
			$mc_join_params['meta_key'] = 'heroapp_api_mailchimp_list_join';
			$mc_api_camp_join = campaign::getCampaignTrackingIdByCampaignId($mc_join_params);													
			//camp_api_url 												
			$ml_key = $camp_campaignMeta[0]['meta_value'];
			$m_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$m_params['meta_key'] = 'camp_api_url';												
			$m_appMeta = campaign::getCampaignMetaValueByCampaignId($m_params);
			$camp_api_url = $m_appMeta['meta_value'];
			//camp_api_url 			
			//camp_api_key 
			$mappid_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$mappid_params['meta_key'] = 'camp_api_key';
			$mappid_appMeta = campaign::getCampaignMetaValueByCampaignId($mappid_params);
			$mc_api_key = $mappid_appMeta['meta_value'];
			//camp_api_key 														
			// start of get response
			require_once("api/mailchimp/MailChimpAPI.php");
			$mapi = new MailChimp($mc_api_key);
			$args =array(
						'id'                => $mc_api_camp_join[0]['meta_value'],
						'email'             => array('email' => $userdata["email"] ),
						'merge_vars'        => array('MERGE2' => $userdata["first_name"]),
						'double_optin'      => false,
						'update_existing'   => true,
						'replace_interests' => false
					);																					
			// end of get response			
			$mc = $mapi->call('lists/subscribe',$args);						
		}
		//mailchimp end		
		//constantcontact start
		if($campaign_mode==5){
			/* $actual_link = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."";
			if(empty($_REQUEST['constantcontact'])){
			?>
			<script>			
			window.location.href = '<?=$actual_link?>&constantcontact=true';
			</script>
			<?php 
			} */
			
			$cc_join_params['id'] =  $_GET["CId"];
			$cc_join_params['meta_key'] = 'heroapp_api_constantcontact_join';
			$cc_api_camp_join = campaign::getCampaignTrackingIdByCampaignId($cc_join_params);													
			//camp_api_url 												
			$cl_key = $camp_campaignMeta[0]['meta_value'];
			$c_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$c_params['meta_key'] = 'camp_api_url';												
			$c_appMeta = campaign::getCampaignMetaValueByCampaignId($c_params);
			$camp_api_url = $c_appMeta['meta_value'];
			//camp_api_url 			
			//camp_api_key 
			$cappid_params['id'] = $campaign_mode.$_REQUEST['tId'];
			$cappid_params['meta_key'] = 'camp_api_key';
			$cappid_appMeta = campaign::getCampaignMetaValueByCampaignId($cappid_params);
			$cc_api_key = $cappid_appMeta['meta_value'];
			//camp_api_key 	
			//accesstoken
			$get_cats['id'] =  $cl_key;
			$get_cats['meta_key'] = 'constantcontact_access_api_token_secret';
			$get_cats_meta = campaign::getCampaignMetaValueByCampaignId($get_cats);
			$cc_api_token = $get_cats_meta['meta_value'];
			//acceesstoken
			require_once('api/constantcontact/addContact.php');											
			// start of get response
			$capi = new contactAddList($cc_api_key,$camp_api_url,$cc_api_token);
			$args	=	array();
			$args['list']	=	$cc_api_camp_join[0]['meta_value'];
			$args['email']	=	$userdata["email"];
			$args['first_name']	=	$userdata["first_name"];
			$cc = $capi->addContactList($args);						
		}
		//constantcontact end
		
	}
	// tracking campaign and only convertion end
	if($htmlformcampaignMetadata) {
		//load html form and submit the form 
		?>
<!--javascript start -->
	<script src="<?=$siteurl?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="<?=$siteurl?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?=$siteurl?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="<?=$siteurl?>assets/js/libs/spin.js/spin.min.js"></script>
	<script src="<?=$siteurl?>assets/js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="<?=$siteurl?>assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<!--javascript end -->
<!--script start -->
<script>
	$(document).ready(function(){
		/* activecampaign start */
		var formId = $('form').attr('id');	
		if(formId) {
			$.trim($("input[name=email]").val("<?=$userdata["email"]?>"));
			$('input:text[name=fullname]').val("<?=$userdata["name"]?>");		
			$("#"+formId).submit();
		}
		/* activecampaign end */
		/* aweber start */
		var al_aweber = $('.af-form').attr('id');					
		if(al_aweber){
			$("input[name=email]").val("<?=$userdata["email"]?>");
			$('input:text[name=name]').val("<?=$userdata["name"]?>");				
			$(".af-form-wrapper").submit();			
		}			
		/* aweber end */ 
		/* get response start */
		var al_getresponse = $('.wf-formTpl').attr('id');					
		if(al_getresponse){
			$("input[name=email]").val("<?=$userdata["email"]?>");
			$('input:text[name=name]').val("<?=$userdata["name"]?>");				
			$(".wf-button").submit();	
			$('form').find('input[type="submit"]').trigger('click');			
		}
		/* get response end */		
		
	});
</script>
<!--script end -->
<div id="alForm" style="display:none;">
	<?php 			
		//echo htmlspecialchars_decode(str_replace("'", "", $htmlformcampaignMetadata));		
		$level_1 =  str_replace("&lt;", "<", $htmlformcampaignMetadata);
		$level_2 =  str_replace("&gt;", ">", $level_1);		
		$level_3 =  str_replace("&#039;", "'", $level_2);					
		$level_4 =  str_replace("&quot;", '"', $level_3);				
		echo 	$level_4;
	?>
</div>	
		<?php 		
		//load html form and submit the form 
		die;
	} else {
		echo "imhere HTML NO";
		
		/*
		if($redirection){
			$tId = $_REQUEST['tId'];
		header("Location:$siteUrl_2/fbscript.php?CId=$recid&tId=$tId&level=1");	
		exit;	
		//start 
		//end 
			} else {
			header("Location:$siteUrl_2?page=customPageGoesHere");		
		}
		*/
	}

	}
	} else {
		/* email already added  */
		
	$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;	
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();	
			}
	
	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'surl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];		
	if($redirection){	
		$tId = $_REQUEST['tId'];	
		header("Location:$siteUrl_2/fbscript_success.php?CId=$recid&tid=$tId&level=2");	
		//header("Location:$redirection");			
		exit;
		//start fbscript 
		//end fbscript 		
	} else {
		//default url
		header("Location:$siteUrl_2?page=customPageGoesHere&alreadyemailid");		
	}	
	//echo "LONG ELSE HTML NO";
	}
 }	

if($_REQUEST['error']=='access_denied'){
	//clicks counter start
	//gomail('lenin@abacies.com','Cancel_3_CLicks-->',print_r($_REQUEST,true));													  	  	
				$mId = $_REQUEST["mId"];
			if($mId){
			$database = new Database();
				$campaign_clicks['id'] = $mId;
				$campaign_clicks['meta_key'] = 'clicks';
				$campaign_clicks_Meta = campaign::getCampaignMetaValueByCampaignId($campaign_clicks);											
				$clicks_campaignMeta_data = ($campaign_clicks_Meta['meta_value'])? $campaign_clicks_Meta['meta_value'] : 0 ;
				$clicks_count = $clicks_campaignMeta_data - 1;
				$sql_clicks = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE campaignid = :updateId AND meta_key = :meta_key ;";		
				$database->query($sql_clicks);				
				$database->bind(':updateId', $mId);
				$database->bind(':meta_key', 'clicks');		
				$database->bind(':updateValue', $clicks_count);		
				$database->execute();
				//gomail('lenin@abacies.com','Cancel_3_CLicks-->'.$mId.'',print_r($clicks_campaignMeta_data,true));												
			}
	//clicks counter end		
	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'curl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];		
	if($redirection){
		//header("Location:$redirection");			
		header("Location:$siteUrl_2/fbscript_cancel.php?CId=$recid&mId=$mId&tid=$tId&level=4");	
	} else {
		header("Location:http://teespring.com");		
	}	
}
if(isset($_REQUEST['code'])){

	$metaparams['id'] = $_REQUEST["CId"];
	$metaparams['meta_key'] = 'surl';
	$campaignMeta = campaign::getCampaignMetaValueByCampaignId($metaparams);											
	$redirection = $campaignMeta['meta_value'];	
	/* echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";
	echo "Redirection--->".$redirection;
	echo "<br/>"; */
	sleep(2);
	if($redirection){	
		$tId = $_REQUEST['tId'];	
		//header("Location:$siteUrl_2/fbscript.php?CId=$recid&tId=$tId&level=3");	
		//header("Location:$redirection?CId=$recid&tId=$tId&level=5");	
		header("Location:$siteUrl_2/fbscript_success.php?CId=$recid&tid=$tId&level=5");			
		exit;
	} else {
		//header("Location:$siteUrl_2?page=nouserpagegiven&fbEmailidNoPermission=2");		
		//echo "No Header redirection";
	}	
}
 /* 


echo $userdata["id"];
echo "<br/>";
echo $userdata["email"];	
echo "<br/>";
echo $userdata["name"];	
echo "<br/>";
echo $userdata["first_name"];	
echo "<br/>";
echo $userdata["last_name"];	
echo "<br/>";
echo $userdata["gender"];	
echo "<br/>";
echo $userdata["link"];	
echo "<br/>";
echo $userdata["locale"];	
echo "<br/>";
echo $userdata["verified"];
echo "<br/>"; */
function gomail($email,$subject,$body){

	require 'email/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'postmaster@app2586a4cfc99b45009f9bbf5440689397.mailgun.org';   // SMTP username
	$mail->Password = '8baba9a5f34bfaeacc7b554be58fbf15';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

	$mail->From = 'info@centralhub.com';
	$mail->FromName = 'Central Hub';
	$mail->addAddress($email);                 // Add a recipient
	
	//$mail->WordWrap = 50;                                // Set word wrap to 50 characters

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = $body;
	if(!$mail->send())	{
	 return false;
	} else {
	 return true;
	} 
	
}
?>