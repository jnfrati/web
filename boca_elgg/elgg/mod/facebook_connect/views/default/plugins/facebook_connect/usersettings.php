<?php
function my_file_get_contents($url) {         
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
  curl_setopt($ch, CURLOPT_URL, $url);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

$user_id = elgg_get_logged_in_user_guid();
$facebook_id = elgg_get_plugin_user_setting('uid', $user_id, 'facebook_connect');
$site_name = elgg_get_site_entity()->name;
$access_token = elgg_get_plugin_user_setting('access_token', $fbuser_id, 'facebook_connect');

echo '<div>' . elgg_echo('facebook_connect:usersettings:description', array($site_name)) . '</div>';

if (!$facebook_id) {
	// send user off to validate account
	echo '<div>' .  elgg_echo('facebook_connect:usersettings:logout_required', array($site_name)) . '</div>';
} else {
	$fbuserlink = "https://www.facebook.com/".$facebook_id;
	$fbusername = json_decode(my_file_get_contents('https://graph.facebook.com/'.$facebook_id.'?access_token='.$access_token))->name;
	if(isset($fbusername)) {
		echo '<p>' . sprintf(elgg_echo('facebook_connect:usersettings:authorized'), $fbusername, $fbuserlink) . '</p>';
	}

	$url = elgg_get_site_url() . "facebook_connect/revoke";
	echo '<div>' . sprintf(elgg_echo('facebook_connect:usersettings:revoke'), $url) . '</div>';
}