<?php

	include('DB.php');

	$con = DataBase::connect();

	//$sql = 'SELECT usernumber, count(*) AS bienResueltos FROM runtable WHERE runanswer = 1 GROUP BY usernumber ORDER BY bienResueltos DESC';
	$sql = 'SELECT u.username, count(*) AS bienResueltos 
			FROM runtable r 
			INNER JOIN usertable u
			ON r.usernumber = u.usernumber
			WHERE r.runanswer = 1 	
			GROUP BY u.username 
			ORDER BY bienResueltos DESC';

	$sth = $con->prepare($sql);
	$sth->execute();
	$bienR = $sth->fetchAll();


	//$sql = 'SELECT u.username, count(*) AS bienResueltos 
	//		FROM runtable r 
	//		INNER JOIN usertable u
	//		ON r.usernumber = u.usernumber
	//		WHERE r.runanswer = 1 	
	//		GROUP BY u.username 
	//		ORDER BY bienResueltos DESC';

	$sql = "SELECT username FROM usertable WHERE usernumber NOT IN((SELECT usernumber FROM runtable WHERE runanswer = 1)) AND NOT username = 'system' AND NOT username = 'admin'";

	$sth = $con->prepare($sql);
	$sth->execute();
	$noRes = $sth->fetchAll();


	//var_dump($noRes);
	//var_dump($red);
	$tabla = array_merge($bienR,$noRes);



$TablaDePuntajesGral = <<< prueba
<!DOCTYPE html>
<html>
<head>
	<title>Score Table</title>
</head>
<body>
	<table class="elgg-table">
		<tr>
			<th>
				<p>Puesto</p>
			</th>
			<th>
				<p>UserName</p>
			</th>
			<th>
				<p>Bien Resueltos</p>
			</th>
		</tr>
prueba;
		$filas = "";
		$i=1;
		foreach ($tabla as $tabla2) {
			
			if($tabla2['bienresueltos']==null){
				$tabla2['bienresueltos'] = 0;
			}


			$filas.= "<tr>
						<td>
							<p> $i </p>
						</td>
						<td>
							<p><a href='/elgg/profile/".$tabla2['username']."'>". $tabla2['username']."</a></p>
						</td>
						<td>
							<p>".$tabla2['bienresueltos']."</p>
						</td>
					</tr>";


			++$i;
		}
$filas .="		
	</table>
</body>
</html>";
return $TablaDePuntajesGral . $filas;
?>