<?php
	require_once('/var/www/boca/src/db.php');

	$contestnumber = 1;
	$site = 1;
	$user = 1000;
	$userip = "";
	$icpcid = "";
	$multiLogin = "t";
	$userenabled = "t";
	$userfullname = "";
	$userdesc = "";
	$usertype = "team";

	$param['user'] = htmlspecialchars($guid);
	$param['site'] = $site;
	$param['username'] = htmlspecialchars($username);
	$param['usericpcid'] = $icpcid;
	$param['enabled'] = $userenabled;
	$param['multilogin'] = htmlspecialchars($multiLogin);
	$param['userfull'] = $userfullname;
	$param['userdesc'] = $userdesc;
	$param['type'] = $usertype;
	$param['permitip'] = $userip;
	$param['contest'] = $contestnumber;
	$param['changepass']='t';
	
	DBNewUser($param);
?>

