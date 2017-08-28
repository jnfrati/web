
<?php
require_once('../boca/src/db.php');

$usernumber = 1;        //$_SESSION["usertable"]["usernumber"]
$contestnumber = 1;     //$_SESSION["usertable"]["contestnumber"]
$usersitenumber = 1;    //$_SESSION["usertable"]["$usersitenumber"]
$usertype = "team";     //$_SESSION["usertable"]["usertype"]
$username = "rex";   //$_SESSION["usertable"]["username"]
$locr = "";             //$_SESSION["locr"] ????
//$forceredo ???
$ds = DIRECTORY_SEPARATOR;
if($ds=="") $ds = "/";

$run = DBUserRuns($contestnumber,
                  $usersitenumber,
                  $usernumber);
                  
$prob = DBGetProblems($contestnumber,
                      $usertype=='judge');

$lang = DBGetLanguages($contestnumber);

//~ $_SESSION["popuptime"] = time();
//~ $_SESSION['forceredo']=false;
/*
if(($st = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
    ForceLoad("../index.php");
*/
?>
    <br>
    <table width="100%" border=1>
        <tr>
            <td><b>Run #</b></td>
            <td><b>Time</b></td>
            <td><b>Problem</b></td>
            <td><b>Language</b></td>
            <td><b>Answer</b></td>
            <td><b>File</b></td>
        </tr>
<?php        
	$strcolors = "0";
                      
    if (count($run) == 0)
        echo "<br><center><b><font color=\"#ff0000\">NO RUNS AVAILABLE</font></b></center>";
    else
        foreach($run as $item){
            $myAnswer = "Not answered yet";
            $myUrl = filedownload($item["oid"], $item["filename"]);
            
            if (trim($item["answer"]) != ""){
                $myAnswer = $item["answer"];
                
                if($item['yes'] == 't') {
                    $strcolors .= "\t" . $item["colorname"] . "\t" . $item["color"];
                    $myAnswer .= "<img alt='" . $item["colorname"] . "' width='15' src='" . balloonurl($item["color"]) . "' />";
                }
                
            }
?>        
		<tr>
            <td nowrap><?= $item["number"] ?></td>
            <td nowrap><?= dateconvminutes($item["timestamp"]) ?></td>
            <td nowrap><?= $item["problem"] ?></td>
            <td nowrap><?= $item["language"] ?></td>
            <td><?= $myAnswer ?></td>
            <td nowrap>
                <a href="boca/src/filedownload.php?<?= $myUrl ?>"><?=$item["filename"] ?></a>
            </td>
        </tr>
<?php        
        }
?>

    </table>
    
    <br><br><center><b>To submit a program, just fill in the following fields:</b></center>
    <form name="form1" enctype="multipart/form-data" method="post" action="runSave.php">

        <input type=hidden name="confirmation" value="noconfirm" />
        <center>
        <table border="0">
        <tr> 
            <td width="25%" align=right>Problem:</td>
            <td width="75%">
                <select name="problem">
                    <option selected value="-1"> -- </option>
<?php                
                    foreach($prob as $item)
                        echo "<option value='" . $item["number"] . "'>" . $item["problem"] . "</option>";
?>
                        
                </select>
            </td>
        </tr>
        <tr> 
            <td width="25%" align=right>Language:</td>
            <td width="75%"> 
                <select name="language">
                    <option selected value="-1"> -- </option>
<?php
                    foreach($lang as $item)
                        echo "<option value='" . $item["number"] . "'>" . $item["name"] . "</option>";
?>                    
                </select>
            </td>
        </tr>
        <tr> 
            <td width="25%" align=right>Source code:</td>
            <td width="75%">
                <input type="file" name="sourcefile" size="40">
            </td>
        </tr>
        </table>

        <input type="submit" name="Submit" value="Send" onClick="return conf();">
        <input type="reset" name="Submit2" value="Clear">
    </center>
</form>

<script language="javascript">
    function conf() {
        if (document.form1.problem.value != '-1' && document.form1.language.value != '-1') {
            if (confirm("Confirm submission?")){
                document.form1.confirmation.value = 'confirm';
                return true;
            }
        } else {
            alert('Invalid problem and/or language');
            return false;
        }
    }
</script>
</body>
</html>

<?php
// CREO QUE NO SIRVE, ANALIZAR SACAR...

//~ $runtmp = $_SESSION["locr"] . $ds . "private" . $ds . "runtmp" . $ds . "run-contest" . $_SESSION["usertable"]["contestnumber"] . 
	//~ "-site". $_SESSION["usertable"]["usersitenumber"] . "-user" . $_SESSION["usertable"]["usernumber"] . ".php";

$runtmp = $locr . $ds . "private" . $ds . "runtmp" . $ds . "run-contest" . $contestnumber . 
	"-site". $usersitenumber . "-user" . $usernumber . ".php";

    $conf=globalconf();
    $strtmp1 = "<!-- " . time() . " --> <?php exit; ?>\t" . encryptData($strcolors,$conf["key"],false) . "\n" . encryptData($strtmp,$conf["key"],false);
	$randnum = session_id() . "_" . rand();
	if(file_put_contents($runtmp . "_" . $randnum, $strtmp1,LOCK_EX)===FALSE) {
		if(!isset($_SESSION['writewarn'])) {
			LOGError("Cannot write to the user-run cache file $runtmp -- performance might be compromised");
			$_SESSION['writewarn']=true;
		}
	}
	@rename($runtmp . "_" . $randnum, $runtmp);

?>
