<?php
	

	class DataBase{

		public $user = "bocauser";
		public $host = "localhost";
		public $dbname = "bocadb";
		public $password = "boca";


		static function connect() {

			try{
				$dbh = new PDO("pgsql:dbname=bocadb;host=localhost", "bocauser", "boca");
			}catch(PDOException $e){
				echo $e;
				exit;
			}

			return $dbh;

		}


	}