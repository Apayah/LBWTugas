<?php
if(!session_id()) {
    session_start();
}

require_once __DIR__ . '\php-graph-sdk-5.4\src\Facebook/autoload.php';

$fb = new Facebook\Facebook([
	'app_id' => '1107797339327400',
	'app_secret' => 'e8fb90de2a684e8464b1247421ee4891',
	'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://localhost:81/LBWTugas/main.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>