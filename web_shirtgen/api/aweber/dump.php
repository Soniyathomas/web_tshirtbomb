<?php 
require_once('aweber_api.php');
$consumerKey = "AkPr4hpwR9P4Z2qyf01ettFO"; # Put your consumer key here
$consumerSecret = "VqlhnvJ9kcLK4hCDPxC76rGZDhl83cTokT9mArjz"; # Put your consumer secret key here
$aweber = new AWeberAPI($consumerKey, $consumerSecret);
?>
<?php 
// Authenticate your account using "oauth"
if (empty($_COOKIE['accessToken'])) {
if (empty($_GET['oauth_token'])) {
$callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

list($requestToken, $requestTokenSecret) = $aweber->getRequestToken($callbackUrl);
setcookie('requestTokenSecret', $requestTokenSecret);
setcookie('callbackUrl', $callbackUrl);
header("Location: {$aweber->getAuthorizeUrl()}");
exit();
}

$aweber->user->tokenSecret = $_COOKIE['requestTokenSecret'];
$aweber->user->requestToken = $_GET['oauth_token'];
$aweber->user->verifier = $_GET['oauth_verifier'];
list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();
//db 
setcookie('accessToken', $accessToken);
setcookie('accessTokenSecret', $accessTokenSecret);
header('Location: '.$_COOKIE['callbackUrl']);
exit();
}
?>
<?php 
// Set the cookies to authenticate the user

# Get Aweber Account
$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);
$account_id = $account->id;
foreach ($account->lists as $list) {
print "LIST Name: " . $list->name; echo '&nbsp'; echo '&nbsp'; echo '&nbsp'; print "LIST Id: " . $list->id;
echo "<br>";
}

?>
<?php 

try{
$list_id='3967393'; // Enter list Id here
$listURL = "/accounts/".$account_id."/lists/3967393";
$list=$account->loadFromUrl($listURL);

# create a subscriber
$params = array(
'email' => 'lenin@abacies.com',
'name' => 'lenin'
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