<?php
	require_once('/var/www/html/bocamodif/src/db.php');
	$prob = DBGetFullProblemData(1,true);
$ejercicios = <<< test
		<!DOCTYPE html>
		<html>

		<head>
			<!--<title>Admin Role</title>
			<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css">
			<link rel="stylesheet" type="text/css" href="cssadmin.css">
			<script src="http://code.jquery.com/color/jquery.color-2.1.2.min.js" integrity="sha256-H28SdxWrZ387Ldn0qogCzFiUDDxfPiNIyJX7BECQkDE=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="jsadmin.js"></script>-->
		</head>

		<body>



			<div>
				<center>
					<table border="1" width=100% class="elgg-table">
						<tr>
							<td nowrap="nowrap">Problem #</td>
						  	<td nowrap="nowrap">Short Name</td>
						  	<td nowrap="nowrap">Fullname</td>
						  	<td nowrap="nowrap">Basename</td>
						  	<td nowrap="nowrap">Descfile</td>
						  	<td nowrap="nowrap">Package file</td>
						  	<td nowrap="nowrap">Editar</td>
						  	<td nowrap="nowrap">Eliminar</td>
						</tr>
test;

		$filas="";					


				for($i=1; $i < count($prob); ++$i){  
					$number = $prob[$i]['number'];
					$urlinputfilename = rawurldecode($prob[$i]['inputfilename']);
					$inputfilename = $prob[$i]['inputfilename'];
					$name = $prob[$i]["name"];
					$basefilename = $prob[$i]["basefilename"];
					$downloadfile = filedownload($prob[$i]["descoid"], $prob[$i]["descfilename"]);
					$descfilename = basename($prob[$i]["descfilename"]);
					$downloadpack = filedownload($prob[$i]["inputoid"] ,$prob[$i]["inputfilename"]);


				

		$filas .= "<tr>
					<td nowrap='nowrap'> $number </td>
					<td nowrap='nowrap'> $name </td>
					<td nowrap='nowrap'> $fullname </td>
					<td nowrap='nowrap'> $basefilename </td>
					<td nowrap='nowrap'>$descfilename</td>
					<td nowrap='nowrap'><a href='http://localhost/bocamodif/src/filedownload.php?$downloadpack ?>'> $inputfilename </a></td>
					<td nowrap='nowrap'><a href=\"tap_editor/start.php?n=".base64_encode($number)."&na=".base64_encode($name)."&fu=".base64_encode($fullname)."&ba=".base64_encode($basefilename)."&de=".base64_encode($descfilename)."\"><img src=\"http://localhost/elgg/mod/tap/img/editar.png\" width=30 height=30></a> </td>
					<td nowrap='nowrap'><a href=\"tap_delete/start.php?n=".base64_encode($number)."\"><img src=\"http://localhost/elgg/mod/tap/img/eliminar.png \" width=30 height=30></a> </td>

		 		 	</tr>";

				}

		$filas .= "</table></center></div><br><br><br>";


	return $ejercicios . $filas ;
?>
