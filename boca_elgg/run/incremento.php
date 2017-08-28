<?php
	class Ejecutar{
		public static function postgres(){
			try{
				$mdb = new PDO("pgsql:dbname=bocadb;host='localhost'","bocauser","boca");
				$sql = "SELECT (problemnumber + 1) AS problemnumber FROM problemtable ORDER BY problemnumber DESC LIMIT 1";
				$temp = $mdb->prepare($sql);
				$temp->execute();
				$resultado = $temp->fetchAll();
				return $resultado[0]['problemnumber'];
			}catch(PDOException $e){
				echo "ERROR";
			}
		}

		public static function maicicuel($id, $descripcion, $nombre){
			$host = "localhost";
			$dbname = "elggadd";
			$usuario = "root";
			$contrasenia = "root";
			try{
				$mdb = new PDO("mysql:dbname=$dbname;host=$host",$usuario,$contrasenia);
				$sql = "INSERT INTO ejercicios (id_ex, descripcion, nombre, guid_us) VALUES ($id,'".$descripcion."', '".$nombre."', 36)";
				$temp = $mdb->prepare($sql);
				$temp->execute();
			}catch(PDOException $e){
				echo "ERROR";
				echo "$sql";
				var_dump($e);
			}	
		}

	}
?>
