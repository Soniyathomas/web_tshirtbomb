<?php
session_start();
require_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
<?php
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

		$autoscriptparams_fbScript['id'] = $_REQUEST["CId"];
		$autoscriptparams_fbScript['meta_key'] = 'cancelautoscript';
	    $autoscriptparamscampaignMeta = campaign::getCampaignMetaValueByCampaignId($autoscriptparams_fbScript);		
		
	$metaparams_fbScript['id'] = $_REQUEST["CId"];
	$metaparams_fbScript['meta_key'] = 'curl';
	$campaignMeta_fbScript = campaign::getCampaignMetaValueByCampaignId($metaparams_fbScript);											
	$redirection_fbScript = $campaignMeta_fbScript['meta_value'];
	if(empty($redirection_fbScript)){
		$redirection_fbScript = "http://teespring.com";
	}	
		
		$level_1 =  str_replace("&lt;", "<", $autoscriptparamscampaignMeta['meta_value']);
		$level_2 =  str_replace("&gt;", ">", $level_1);		
		$level_3 =  str_replace("&#039;", "'", $level_2);					
		$level_4 =  str_replace("&quot;", '"', $level_3);				
		echo 	$level_4;
		
	$database = new Database();	
	$database->query('SELECT meta_value FROM  heroku_campaign_meta WHERE  campaignId = :campaignId AND meta_key = :meta_key');
	$database->bind(':meta_key', 'waitingmode');
	$database->bind(':campaignId', $_GET["cid"]);	
	$waitingmode = $database->resultset();
	if($waitingmode[0]['meta_value']){
	$redirwait = $waitingmode[0]['meta_value'];
	}
	else{
	$redirwait = 0;
	}
		
?>
<meta http-equiv="refresh" content="<?=$redirwait?>;URL=<?=$redirection_fbScript?>" />

</head>
<?php 
//header("Location:http://google.co.in");
//file_get_contents("http://google.co.in");
?>

<body>
<p>page is redirecting, please wait.....</P>
</body>

</html> 