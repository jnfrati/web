<?php
	$path = "/var/www/html/bocamodif/src/db.php";
	require "$path";
	$contestnumber = 1;
	$locr = "/var/www/boca/src";


	require_once("incremento.php");
	var_dump($_POST['problemnumber']);
	if(!isset($_POST['problemnumber']) || $_POST['problemnumber'] == '') {

		$problemnum = Ejecutar::postgres();

	}else{

		$problemnum = $_POST['problemnumber'];
	}

	$descripcion = $_POST["problemdesc"];

    Ejecutar::maicicuel($problemnum, $descripcion, trim($_POST['problemname']));

    $name=myhtmlspecialchars($_FILES["probleminput"]["name"]);
	$temp=myhtmlspecialchars($_FILES["probleminput"]["tmp_name"]);



	$param = array();
	$param['number'] = $problemnum;
	$param['name'] = trim($_POST["problemname"]);
	$param['inputfilename'] = $name;
	$param['inputfilepath'] = $temp;
	$param['fake'] = 'f';
	$param['colorname'] = $_POST["colorname"];
	$param['color'] = $_POST["color"];
	DBNewProblem ($contestnumber, $param);

	echo "<script language=\"JavaScript\">\n";
	echo "document.location='http://".$_SERVER['HTTP_HOST']."/elgg/tap';\n";
	echo "</script></html>\n";

?>