<?php 
/*
**********************Email Campaign************************
**************************************************************
*************************************************************
*/

class campaign {
	
	//newCampaign start
	static public function newCampaign($params){
		$results = array();
		$database = new Database();		
		
		$title = $params["title"];
		if($params["title"]!='' && $params["description"]!='') {
		
		$database->query('SELECT * FROM  heroku_email_campaign WHERE  title = :title AND user_id = :userId');
		$database->bind(':title', $title);
		$database->bind(':userId', $params["user_id"]);		
		$rows = $database->resultset();		
		if(empty($rows)){
			//insert 		
			///////////////////////////////////////////////////			
			$sql_insert = "INSERT INTO heroku_email_campaign 
				(user_id, title, description, status,users_count,users_limit,hits,create_date,last_update) 
				VALUES 
				(:userId, :title, :description, :status,:users_count,:users_limit,:hits,:create_date,:last_update);";

			$database->query($sql_insert);				
			$database->bind(':userId', $params["user_id"]);
			$database->bind(':title', $params["title"]);
			$database->bind(':description', $params["description"]);
			$database->bind(':status', $params["status"]);				
			$database->bind(':users_count', 0);
			$database->bind(':users_limit', 0);
			$database->bind(':hits', 0);
			$database->bind(':create_date', date('Y-m-d h:i:s'));						
			$database->bind(':last_update', date('Y-m-d'));								
			$database->execute();			
			/////////////////////////////////////////////////////			
			//echo "<pre>";
			//print_r($database->debugDumpParams());
			//echo "</pre>";
			$results['status'] = 1;
			
		} else {
			//already exist's			 
			 $results['status'] = 2;
			 }
		} else {
			 $results['status'] = 3;			 
		}
		return $results;
		
	} 
	//newCampaign end
	//editCampaign start
	static public function editCampaign($params){
		
	} 	
	//editCampaign end	
	//deleteCampaign start	
	static public function deleteCampaign($params){
		//
		
		$sql = "DELETE FROM heroku_email_campaign WHERE id = :id;";
		$database = new Database;
		$database->query($sql);
		$database->bind(':id', $params['id']);
		$database->execute();
	} 		
	//deleteCampaign end
	//readCampaigns start	
	static public function readCampaignsbycId($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_email_campaign where id = :id";
		$database->query($sql);
		$database->bind(':id', $params['id']);
		$results = $database->single();
		return $results;
		
	} 				
	//readCampaigns end		
	//readCampaignsbyUserIdDesc start 
	static public function readCampaignsbyUserIdDesc($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_email_campaign where user_id = :user_id and status = :status order by id desc";
		$database->query($sql);
		$database->bind(':user_id', $params['user_id']);
		$database->bind(':status', $params['status']);
		$results = $database->single();
		return $results['id'];		
	}		
	//readCampaignsbyUserIdDesc end	
	//readCampaignsbyUserId start	
	static public function readCampaignsbyUserId($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_email_campaign where user_id = :user_id and status = :status order by title asc";
		$database->query($sql);
		$database->bind(':user_id', $params['userId']);
		$database->bind(':status', $params['status']);
		$results = $database->resultset();
		return $results;		
	} 				
	//readCampaignsbyUserId end	
	//readCampaignsbyUserIdPagination start	
	static public function readCampaignsbyUserIdPagination($params){
		$results = array();
		$database = new Database();
		if($params['is_admin']){
			$sql = "SELECT * FROM heroku_email_campaign";			
			$database->query($sql);
			//$database->bind(':start', $params['pag_start']);
			//$database->bind(':end', $params['pag_end']);					
		} else {
			$sql = "SELECT * FROM heroku_email_campaign where user_id = :user_id and status = :status";			
			$database->query($sql);
			$database->bind(':user_id', $_SESSION['userId']);
			$database->bind(':status', 1);		
		}
		$results = $database->resultset();
		return $results;		
	} 				
	//readCampaignsbyUserIdPagination end		
	//getEmailIdsByCampaignId start	
	static public function getEmailIdsByCampaignId($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_fb_users where campaignId = :campaignId AND status = :status";
		$database->query($sql);
		$database->bind(':campaignId', $params['id']);
		$database->bind(':status', 1);
		$results = $database->resultset();
		return $results;		
	} 				
	//getEmailIdsByCampaignId end	
	//getEmailIdsByCampaignId start	
	//getCampaignMetaValueByCampaignId
	static public function getCampaignMetaValueByCampaignId($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_campaign_meta where campaignId = :campaignId AND meta_key = :meta_key";
		$database->query($sql);
		$database->bind(':campaignId', $params['id']);
		$database->bind(':meta_key', $params['meta_key']);		
		$results = $database->single();
		return $results;		
	} 				
	//getCampaignMetaValueByCampaignId end	
	
	//check all email status
		static public function getAllEmailstatus($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT meta_value FROM heroku_campaign_meta where meta_key IN (".$params.")";
		$database->query($sql);
		//$database->bind(':campaignId', $params['id']);
		//$database->bind(':meta_key', $params['meta_key']);		
		$results = $database->resultset();

		return $results;		
	}
	//check all email status
	
	//getCampaignTrackingIdByCampaignId start
	static public function getCampaignTrackingIdByCampaignId($params){
		$results = array();
		$database = new Database();
		$sql = "SELECT * FROM heroku_campaign_meta where campaignId = :campaignId AND meta_key = :meta_key";
		$database->query($sql);
		$database->bind(':campaignId', $params['id']);
		$database->bind(':meta_key', $params['meta_key']);		
		$results = $database->resultset();
		return $results;			
	}
	//getCampaignTrackingIdByCampaignId end	
	//addCampaignMeta start 
	static public function addCampaignMeta($params){
			$database = new Database();
			$database->query('SELECT * FROM  heroku_campaign_meta WHERE  campaignId = :campaignId AND meta_key = :meta_key');
			$database->bind(':meta_key', $params['ckey']);
			$database->bind(':campaignId', $params["cid"]);	
			$rows = $database->resultset();		
			if(empty($rows)){		
			//empty insert 
			$sql_campaign_successUrl = "INSERT INTO heroku_campaign_meta (campaignId, meta_key, meta_value) VALUES (:campaignId, :meta_key, :meta_value);";	
			$database->query($sql_campaign_successUrl);				
			$database->bind(':campaignId', $params["cid"]);
			$database->bind(':meta_key', $params["ckey"]);	
			$database->bind(':meta_value', $params["cvalue"]);		
			$database->execute();				
			} else {		
			//already update 		
			$sql_campaign_successUrl = "UPDATE heroku_campaign_meta SET meta_value = :updateValue WHERE id = :updateId;";		
			$database->query($sql_campaign_successUrl);				
			$database->bind(':updateId', $rows[0]['id']);
			$database->bind(':updateValue', $params["cvalue"]);		
			$database->execute();
			}			
	}
	//addCampaignMeta end 
	
		
}
?>