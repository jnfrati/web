
<?php
require_once('/var/www/boca/src/db.php');

$usernumber = $_SESSION[_sf2_attributes][guid];       //$_SESSION["usertable"]["usernumber"]
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

$form = 
' 
 <br>
    <table width="100%" border=1 class="elgg-table">
        <tr>
            <td><b>Run #</b></td>
            <td><b>Time</b></td>
            <td><b>Problem</b></td>
            <td><b>Language</b></td>
            <td><b>Answer</b></td>
            <td><b>File</b></td>
        </tr>





';

	$strcolors = "0";
                      
    if (count($run) == 0)
        $form.= "</table><br><center><b><font color=\"#ff0000\">NO RUNS AVAILABLE</font></b></center>";
    else{
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
            $form .= '       
    		<tr>
                <td nowrap> '.$item["number"].'</td>
                <td nowrap> '.dateconvminutes($item["timestamp"]).'</td>
                <td nowrap> '.$item["problem"].'</td>
                <td nowrap> '.$item["language"].'</td>
                <td> '.$myAnswer.'</td>
                <td nowrap>
                    <a href="http://localhost/bocamodif/src/filedownload.php?'.$myUrl.'">'.$item["filename"].'</a>
                </td>
            </tr>
            ';

        }
        $form.='</table>';
    }

    
