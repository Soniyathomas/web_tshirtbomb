<?php 
require_once('aweber_api.php');
//consumerkey ==> AkOlOzAdpCRDEvi53j0pIKPY
//consumerSecret==> FB2r4FncW7ScB6bri1UimP9j7mm2PXZEstnJrYAW
//accessTokenSecret==>9YuJNgWtVVfCLbuyEFJ3fV91ZsFls6znWOEYTwJC
//accessToken==>Ag9lxCNanHz4la5vua0xnMbm
//list_id;

$consumerKey = $_REQUEST['consumerKey']; # Put your consumer key here
$consumerSecret = $_REQUEST['consumerSecret'];; # Put your consumer secret key here
$aweber = new AWeberAPI($consumerKey, $consumerSecret);
$accessTokenSecret = $_REQUEST['accessTokenSecret'];
$accessToken = $_REQUEST['accessToken'];
$account = $aweber->getAccount($accessToken, $accessTokenSecret);

$account_id = $account->id;
/* foreach ($account->lists as $list) {
print "LIST Name: " . $list->name; echo '&nbsp'; echo '&nbsp'; echo '&nbsp'; print "LIST Id: " . $list->id;
echo "<br>";
} */

try{
$list_id= $_REQUEST['list_id'];
$listURL = "/accounts/".$account_id."/lists/".$list_id."";
$list=$account->loadFromUrl($listURL);

# create a subscriber
$params = array(
'email' => $_REQUEST['email'],
'name' => $_REQUEST['name']
);
$subscribers = $list->subscribers;
$new_subscriber = $subscribers->create($params);
echo "Thank you for subscribing!";
}

// Catch the exceptions here
catch (Exception $exc) {
print $exc->message; 

}

?>