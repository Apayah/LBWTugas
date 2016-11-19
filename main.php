<?php

if(!session_id()) {
    session_start();
}

require_once('TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => "736439881040166916-PXCM9e1C9Ax524uCCOlpnTopR5DS0d9",
    'oauth_access_token_secret' => "ioMxNrpB2U5IuGMPtoCU8FpWAT9rugLI6G4TY4gFfpcVk",
    'consumer_key' => "RxKjWU2hPNX5Hu9UHgnnZy3sv",
    'consumer_secret' => "brdwMBksATfEsCmWysPk5ZqK6TNBsXMeEbPIuBH5ANkl1rKMfu"
);

$url = 'https://api.twitter.com/1.1/users/show.json';
$getfield = '?screen_name=pewdiepie';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
	
$jsontwitter = json_decode($twitter->performRequest());
$followtwitter = $jsontwitter ->followers_count;

require_once __DIR__ . '\php-graph-sdk-5.4\src\Facebook/autoload.php';

$fb = new Facebook\Facebook([
	'app_id' => '1107797339327400',
	'app_secret' => 'e8fb90de2a684e8464b1247421ee4891',
    'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
}
// Am Successfully Logged In Here

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('193844937315070?fields=id,name,likes',  $_SESSION['facebook_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

function fbLikeCount(){
    $id = '193844937315070';
	$app_id ='1107797339327400';
	$app_secret=  'e8fb90de2a684e8464b1247421ee4891';
	$json_url ='https://graph.facebook.com/'.$id.'?access_token='.$app_id.'|'.$app_secret.'&fields=fan_count';
	$json = file_get_contents($json_url);
	$json_output = json_decode($json);
	
	//Extract the likes count from the JSON object
	if($json_output->fan_count){
	$likes = $json_output->fan_count;
		return $likes;		
	}else{
		return 0;		
	}
}

$followfb = fbLikeCount();


function countfollower($num){

	global $res;
	if($num < 1000){
		return num;
	}
	else if($num < 1000000){
		$res = intval(round($num / 1000));
		return $res .' K';
	}
	else{
		$res = intval(round($num / 1000000 ));
		return $res .' M';
	}
}	

?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  -------------------------------------------------- -->
  <meta charset="utf-8">
  <title>My Idol</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  -------------------------------------------------- -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  -------------------------------------------------- -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  -------------------------------------------------- -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  -------------------------------------------------- -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  -------------------------------------------------- -->
  <div class="container">
    <div class="row">
	    <div class="eight columns">
			<a class="twitter-grid" 
			data-limit="4" 
			data-partner="tweetdeck"
			href="https://twitter.com/JohnGdewira/timelines/799953325290467328">
			Pewdiepie Pictures
			</a>
			<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</a>
		</div>
		<div class="four columns">
			<a class="twitter-timeline"
				href="https://twitter.com/pewdiepie"
				data-height="500"
				data-chrome="transparent">
				Tweets by pewdiepie
			</a> 
			 <table align="center">
                <thead>
                    <tr>
						<th>Twitter Follower</th>
                        <th>Facebook Likes</th>
					</tr>
				</thead>
                <tbody>	
					<tr>
						<th><?php echo countfollower($followtwitter);	?></th>
						<th><?php echo countfollower($followfb);	?></th>
					</tr>
				</tbody>
			</table>				
			<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
      </div>
    </div>

<!-- End Document
  -------------------------------------------------- -->
</body>
</html>