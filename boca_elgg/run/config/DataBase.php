<?php
class DataBase{
	public static function getDb($gdb, $dbName, $tipoUsuario) {
        $host = "localhost";
        if($tipoUsuario == 1){
			$usuario = "bocauser";
			$contrasenia = "boca";
		}else{
			$usuario = "root";
			$contrasenia = "root";	
		}
        //$mdb = new PDO("pgsql:dbname=elgg_prueba;host='localhost'", "elgg", "1234");
        $mdb = new PDO("$gdb:dbname=$dbName;host=$host", $usuario, $contrasenia);
       
        return $mdb;
    }
}
