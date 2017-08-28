<?php
	require_once('/var/www/boca/src/db.php');


//Crear ZIP
	if(isset($_POST['Submit5']) && $_POST['Submit5']=='Send') {
		if(isset($_POST['basename']) && isset($_POST['fullname']) && isset($_POST['timelimit'])){ //&&$_POST["confirmation"] == "confirm") {


			//Verifica que venga un archivo de entrada de datos
			if ($_FILES["probleminput"]["name"] != "") {
				$type=myhtmlspecialchars($_FILES["probleminput"]["type"]);
				$size=myhtmlspecialchars($_FILES["probleminput"]["size"]);
				$name=myhtmlspecialchars($_FILES["probleminput"]["name"]);
				$temp=myhtmlspecialchars($_FILES["probleminput"]["tmp_name"]);
				if (!is_uploaded_file($temp)) {
					ob_end_flush();
					IntrusionNotify("file upload problem.");
					ForceLoad("index.php");
				}
			} else $name = "";

			//Verifica que venga un archivo de solucion de datos
			if ($_FILES["problemsol"]["name"] != "") {
				$type1=myhtmlspecialchars($_FILES["problemsol"]["type"]);
				$size1=myhtmlspecialchars($_FILES["problemsol"]["size"]);
				$name1=myhtmlspecialchars($_FILES["problemsol"]["name"]);
				$temp1=myhtmlspecialchars($_FILES["problemsol"]["tmp_name"]);
				if (!is_uploaded_file($temp1)) {
					ob_end_flush();
					IntrusionNotify("file upload problem.");
					ForceLoad("index.php");
				}
			} else $name1 = "";

			//Verifica que venga un archivo de descripcion de datos
			if (isset($_FILES["problemdesc"]) && $_FILES["problemdesc"]["name"] != "") {
				$type2=myhtmlspecialchars($_FILES["problemdesc"]["type"]);
				$size2=myhtmlspecialchars($_FILES["problemdesc"]["size"]);
				$name2=myhtmlspecialchars($_FILES["problemdesc"]["name"]);
				$temp2=myhtmlspecialchars($_FILES["problemdesc"]["tmp_name"]);
				if (!is_uploaded_file($temp2)) {
					ob_end_flush();
					IntrusionNotify("file upload problem.");
					ForceLoad("index.php");
				}
			} else $name2 = "";


			$ds = DIRECTORY_SEPARATOR;
			if($ds=="") $ds = "/";
			$tmpdir = getenv("TMP");
			if($tmpdir=="") $tmpdir = getenv("TMPDIR");
			if($tmpdir[0] != $ds) $tmdir = $ds . "tmp";
			if($tmpdir=="") $tmpdir = $ds . "tmp";

			//Crea las carpetas de resolucion del problema
			$tfile = tempnam($tmpdir, "problem");
			if(@mkdir($tfile . "_d", 0700)) {
				$dir = $tfile . "_d";
				@mkdir($dir . $ds . 'limits');
				@mkdir($dir . $ds . 'compare');
				@mkdir($dir . $ds . 'compile');
				@mkdir($dir . $ds . 'run');
				@mkdir($dir . $ds . 'input');
				@mkdir($dir . $ds . 'output');
				@mkdir($dir . $ds . 'tests');
				@mkdir($dir . $ds . 'description');
				
				//Crea Archivos de compilacion
				$filea = array('compare' . $ds . 'c','compare' . $ds . 'cpp','compare' . $ds . 'java',
							   'compile' . $ds . 'c','compile' . $ds . 'cpp','compile' . $ds . 'java',
							   'run' . $ds . 'c','run' . $ds . 'cpp','run' . $ds . 'java');
				
				//Crea problemtemplate con todas las carpetas del array
				foreach($filea as $file) {
					 $rfile='..' . $ds. 'boca' . $ds . 'doc' . $ds . 'problemexamples' . $ds . 'problemtemplate' . $ds . $file;
					if(is_readable($rfile)) {
						@copy($rfile, $dir . $ds . $file);
					} else {
						@unlink($tfile);
						cleardir($dir);
						ob_end_flush();
						MSGError('Could not read problem template file ' . $rfile);
						ForceLoad('admin.php');
					}
				}


				$tl = explode(',',$_POST['timelimit']);
				
				if(!isset($tl[1]) || !is_numeric(trim($tl[1]))) $tl[1]='1';
				$str = "echo " . trim($tl[0]) . "\necho " . trim($tl[1]) . "\necho 512\necho " . floor(10 + $size1 / 512) . "\nexit 0\n";
				file_put_contents($dir . $ds . 'limits' . $ds . 'c',$str);
				file_put_contents($dir . $ds . 'limits' . $ds . 'cpp',$str);
				file_put_contents($dir . $ds . 'limits' . $ds . 'java',$str);
				$str = "basename=" . trim($_POST['basename']) . "\nfullname=" . trim($_POST['fullname']);
				if($name2) {
					@copy($temp2, $dir . $ds . 'description' . $ds . $name2);
					@unlink($temp2);
					$str .= "\ndescfile=" . $name2;
				}
				$str .= "\n";
				file_put_contents($dir . $ds . 'description' . $ds . 'problem.info',$str);
				if($name && $name1) {
					@copy($temp, $dir . $ds . 'input' . $ds . 'file1');
					@unlink($temp);
					@copy($temp1, $dir . $ds . 'output' . $ds . 'file1');
					@unlink($temp1);
				} else {
					@unlink($tfile);
					cleardir($dir);
					ob_end_flush();
					MSGError('Could not read problem input/output files');
					ForceLoad('admin.php');
				}
				$ret=create_zip($dir, glob($dir . $ds . '*'),$dir . '.zip');
				cleardir($dir);
				if($ret <= 0) {
					@unlink($tfile);
					@unlink($dir . '.zip');
					ob_end_flush();
					MSGError('Could not write to zip file');
					ForceLoad('admin.php');
				}
				$str = file_get_contents($dir . '.zip');
				@unlink($dir . '.zip');
				@unlink($tfile);
				header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
				header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header ("Cache-Control: no-cache, must-revalidate");
				header ("Pragma: no-cache");
				header ("Content-transfer-encoding: binary\n");
				header ("Content-type: application/force-download");
				header ("Content-Disposition: attachment; filename=" . basename($dir . '.zip'));
				ob_end_flush();
				echo $str;
				exit;
			} else {
				@unlink($tfile);
				ob_end_flush();
				MSGError('Could not write to temporary directory');
			}
		}
	ForceLoad('admin.php');
	}
?>