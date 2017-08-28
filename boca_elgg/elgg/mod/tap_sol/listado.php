<?php
include('/var/www/html/run/config/DataBase.php');
$mdb = DataBase::getDb('pgsql', 'bocadb', 1);
$sql = "SELECT problemnumber, problemname FROM problemtable WHERE problemnumber <> 0 ORDER BY problemname";
$temp = $mdb->prepare($sql);
$temp->execute();
$resultado = $temp->fetchAll();
$form = " 
<html>
	<title></title>
	<body>
	";
	
	foreach($resultado as $res){
		$form .= "<a href='/elgg/tap_subir_ejercicio/start.php?numero=".$res['problemnumber']."'>Ejercicio ".$res['problemname']." </a></br>";
		
		}
$form .= "</body>
</html>
";

return $form;
?>
