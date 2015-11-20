<?php 
require_once("config/databaseConfig.php");
require_once("config/pdoQuery.php");
require_once("class/campaign/campaignClass.php");
//activecampaign api  start
require_once("api/activecampaign/coreClass.php");
require_once("api/activecampaign/campaign_create.php");
require_once("api/activecampaign/list_add.php");
//activecampaign api end
//activecampaign api start 
if($_GET["cid"] || $_GET["CId"]) {
require_once("api/getresponse/GetResponseAPI.class.php");
require_once("api/getresponse/API.class.php");
/*aweber start */
require_once('api/aweber/aweber_api.php');

require_once('api/aweber/exceptions.php');
require_once('api/aweber/oauth_adapter.php');
require_once('api/aweber/oauth_application.php');
require_once('api/aweber/aweber_response.php');
require_once('api/aweber/aweber_collection.php');
require_once('api/aweber/aweber_entry_data_array.php');
require_once('api/aweber/aweber_entry.php');

/*aweber end */

require_once("api/mailchimp/MailChimpAPI.php");
require_once("api/constantcontact/contactList.php");
require_once('api/constantcontact/contactAuthcode.php');
}
?>
