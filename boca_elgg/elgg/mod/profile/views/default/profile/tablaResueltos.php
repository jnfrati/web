
<?php

	//$user = elgg_get_page_owner_entity();

	
	include('/var/www/html/run/DB.php');


	$con = DataBase::connect();
	//$name = $user->name();
	//$sql = 'SELECT username FROM usertable;';
	$sql = "SELECT u.usernumber,p.problemname FROM usertable u INNER JOIN runtable r ON u.usernumber = r.usernumber INNER JOIN problemtable p ON r.runproblem = p.problemnumber WHERE r.runanswer = 1 AND u.username LIKE '$user->username'";

	$sth = $con->prepare($sql);
	$sth->execute();
	$resueltos = $sth->fetchAll();


    $sql = "SELECT p.problemname, count(*) FROM problemtable p INNER JOIN runtable r ON r.runproblem = p.problemnumber WHERE r.runanswer NOT IN (0,1)  AND r.usernumber =".$resueltos[0]['usernumber']." GROUP BY p.problemname";

    $sth = $con->prepare($sql);
	$sth->execute();
	$envios = $sth->fetchAll();

	
/*
var_dump($resueltos);
var_dump($envios);

var_dump($array);
*/
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $(".btn").click(function(){
	    $(".expand1").toggle();
	  });
	});
</script>
<style type="text/css">
	.expand1 { 
		display: none;
	}
</style>

<table class="elgg-table">
 <tr>
 	<th class="btn">Problemas resueltos</th>
  	<th class="btn">(click para desplegar)</th>
 	<th class="btn">Errores</th>
 </tr>

<?php 
foreach ($resueltos as $res) {
	$flag = 1;
	foreach ($envios as $env) {
		if($res['problemname'] === $env['problemname']){
			$errores = $env['count'];
			$flag = 0;
		}
	}

	if($flag){
		$errores = 0;
	}


?>

 <tr>
 	<td class="expand1" style="text-align: center;"><?=$res['problemname']?></td>
 	<td class="expand1"></td>
 	<td class="expand1" style="text-align: center;"><?=$errores?></td>
 </tr>

<?php 
	}
?>
</table>