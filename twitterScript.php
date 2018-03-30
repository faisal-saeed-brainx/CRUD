<?php
include 'utils.php';
require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
// define the consumer key and secet and callback
define('CONSUMER_KEY', 'K9zZgS7D9dheZQuaQIo9YHYpI');
define('CONSUMER_SECRET', 'EpWtPFKtw9cjpuL2uVRqCRMo6tXp2VVQ2XSkOROaP3oGH7RxJe');
define('OAUTH_CALLBACK', 'https://test.brainxtech.com/CRUD/signup_form.php');
$access_token='290541103-xFpJtJyt1DlbGFVf9ikvuorktnZQsYndc1s1j9If';
$access_token_secret='iT2Xt7uAGtwf9UOBUMNBBCCugCm63314DAWnARQaX6VH5';
// start the session
session_start();

/* 
 * PART 2 - PROCESS
 * 1. check for logout
 * 2. check for user session  
 * 3. check for callback
 */

// 1. to handle logout request
if(isset($_GET['logout'])){
  //unset the session
  session_unset();
  // redirect to same page to remove url paramters
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}


// 2. if user session not enabled get the login url
if(!isset($_SESSION['user_id']) && !isset($_GET['oauth_token'])) {
  // create a new twitter connection object
  $connection =  new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
  $content = $connection->get("account/verify_credentials");
  //var_dump($content);
  // get the token from connection object
  //$request_token = $connection->getRequestToken(OAUTH_CALLBACK); 

  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

  // if request_token exists then get the token and secret and store in the session
  if($request_token){
    $token = $request_token['oauth_token'];
    $token_secret = $request_token['oauth_token_secret'];
    $_SESSION['request_token'] = $token ;
    $_SESSION['request_token_secret'] = $token_secret;
    // get the login url from getauthorizeurl method
   $login_url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    //echo $token. " , ". $token_secret;
  }
}

// 3. if its a callback url
if(isset($_GET['oauth_token'])){
	echo $_GET['oauth_token'];
  // create a new twitter connection object with request token
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);
  // get the access token from getAccesToken method
  //$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
  $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
  if($access_token){  
    // create another connection object with access token
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    // set the parameters array with attributes include_entities false
    $params =array('include_entities'=>'false','include_email' => 'true');
    // get the data
    $data = $connection->get('account/verify_credentials', $params);
    var_dump($data);
    if($data){

      // store the data in the session
      //$_SESSION['data']=$data;
    include('twitterScriptApi.php');
      // redirect to same page to remove url parameters
      //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }
  }
}

/* 
 * PART 3 - FRONT END 
 *  - if userdata available then print data
 *  - else display the login url
*/

/*if(isset($login_url) && !isset($_SESSION['data'])){
  // echo the login url
  echo "<a href='$login_url'><button>Login with twitter </button></a>";
}
else{
  // get the data stored from the session
  $data = $_SESSION['data'];
  //var_dump($data);
   //echo the name username and photo
  echo "Name : ".$data->name."<br>";
  echo "Username : ".$data->screen_name."<br>";
  echo "Email: ".$data->email."<br>";
  echo "Photo : <img src='".$data->profile_image_url."'/><br><br>";
  //echo the logout button
  echo "<a href='?logout=true'><button>Logout</button></a>";
} */


?>