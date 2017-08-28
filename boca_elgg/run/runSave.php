<?php
include('../bocamodif/src/db.php');

$usernumber=$_POST['usernumber'];
$contestnumber=1; //$_SESSION["usertable"]["contestnumber"]
$usersitenumber = 1;  //$_SESSION["usertable"]["$usersitenumber"]
$usertype="team"; //$_SESSION["usertable"]["usertype"]
$locr =""; //$_SESSION["locr"]
//$forceredo ???
$ds = DIRECTORY_SEPARATOR;


if($ds=="") $ds = "/";


if(isset($_POST['name']) && $_POST['name'] != '') {
	echo "RESULT: PARAMETERS MISSING";
	exit;
}



if (!isset($_POST["problem"])){
    echo "PROBLEM MISSING";
    exit;
}
$prob = myhtmlspecialchars($_POST["problem"]);
//$prob = $_POST["problem"];
if(!is_numeric($prob)) {
    $probs = DBGetProblems($contestnumber,$usertype=='judge');
    // busco el nombre del problema y lo reemplazo por su código
    foreach($probs as $item){
        if($item["problem"] == $prob) {
            $prob = $item["number"];
            break;
        }
    }
}
echo "hasta aca".$prob;


if (!isset($_POST["language"])){
    echo "LANGUAGE MISSING";
    exit;
}
$lang = myhtmlspecialchars($_POST["language"]);

if(!is_numeric($lang)) {
    $langs = DBGetLanguages($contestnumber);
    // busco el nombre del lenguaje y lo reemplazo por su código
    foreach ($langs as $item) {
        if($item["name"] == $lang) {
            $lang = $item["number"];
            break;
        }
    }
}

if ((isset($_FILES["sourcefile"]) && $_FILES["sourcefile"]["name"]!="") || (isset($_POST["data"]) && isset($_POST["name"]))) {
	//~ if ($_POST["confirmation"] == "confirm" || (isset($_POST["data"]) && isset($_POST["name"]))) {
		
		if(isset($_POST['name']) && $_POST['name'] != '') {
			$temp = tempnam("/tmp","bkp-");
			$fout = fopen($temp,"wb");
			fwrite($fout,base64_decode($_POST['data']));
			fclose($fout);
			$size=filesize($temp);
			$name=$_POST['name'];
			if ($size > $ct["contestmaxfilesize"] || strlen($name) > 100 || strlen($name) < 1) {
				echo "\nRESULT: SUBMITTED FILE (OR NAME) TOO LARGE";
				exit;
			}
		} else {			
			$type=myhtmlspecialchars($_FILES["sourcefile"]["type"]);
			$size=myhtmlspecialchars($_FILES["sourcefile"]["size"]);
			$name=myhtmlspecialchars($_FILES["sourcefile"]["name"]);
			$temp=myhtmlspecialchars($_FILES["sourcefile"]["tmp_name"]);

		}
        if(strpos($name,' ') === true || 
           strpos($name,'/') === true || 
		   strpos($name,'`') === true || 
           strpos($name,'\'') === true || 
		   strpos($name, "\"") === true || 
           strpos($name,'$') === true || 
           strpos($temp,' ') === true || 
           strpos($temp,'/') === true ||
           strpos($temp,'`') === true || 
           strpos($temp,'\'') === true ||
           strpos($temp, "\"") === true || 
           strpos($temp,'$') === true) {
			if(isset($_POST['name']) && $_POST['name'] != '') {
				echo "\nRESULT: FILE NAME PROBLEM (EG CANNOT HAVE SPACES)";
				exit;
			}
			MSGError("File name cannot contain spaces.");
			ForceLoad($runteam);		
		}
        $ac = array('contest','site','user','problem','lang','filename','filepath');
		$ac1 = array('runnumber','rundate','rundatediff','rundatediffans','runanswer','runstatus','runjudge','runjudgesite',
			   'runjudge1','runjudgesite1','runanswer1','runjudge2','runjudgesite2','runanswer2',
			   'autoip','autobegindate','autoenddate','autoanswer','autostdout','autostderr','updatetime');
		
        $param = array('contest'=>$contestnumber,
					   'site'=>$usersitenumber,
					   'user'=>  $usernumber,
					   'problem'=>$prob,
					   'lang'=>$lang,
					   'filename'=>$name,
					   'filepath'=>$temp);
		

		
		$retv = DBNewRun ($param);
	
}


header('Location: http://'.$_SERVER['HTTP_HOST'].'/elgg/tap_run');
?>
