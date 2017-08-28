<?php
	include('/var/www/html/run/config/DataBase.php');
	class Problema{
		private $problemnumber;
		private $problemname;
		private $problemfullname;
		private $problembasefilename;
		private $probleminputfilename;
		private $probleminputfilehash;
		private $downloadfile;
		private $descfilename;
		private $downloadpack;
		private $problemState;
		
		public function __construct($problemnumber, $problemname = "", $problemfullname = "", $problembasefilename = "",
			$probleminputfilename = "", $probleminputfilehash = "", $descfilename = ""){
			$this->setNumber($problemnumber);
			$this->setName($problemname);
			$this->setFullname($problemfullname);
			$this->setBasefilename($problembasefilename);
			$this->setInputFileName($probleminputfilename);
			$this->setInputFileHash($probleminputfilehash);
			$this->setDescFileName($descfilename);
			//$this->setDownloadfile($downloadfile);
			//$this->setDescfilename($descfilename);
			//$this->setDownloadpack($downloadpack);
			//$this->setProblemState($problemState);
		}

		public function getNumber(){
			return $this->problemnumber;
		}

		public function getUrlinputfilename(){
			return $this->urlinputfilename;
		}

		public function getInputfilename(){
			return $this->probleminputfilename;
		}

		public function getName(){
			return $this->problemname;
		}

		public function getFullname(){
			return $this->problemfullname;
		}

		public function getBasefilename(){
			return $this->problembasefilename;
		}

		public function getDownloadfile(){
			return $this->downloadfile;
		}

		public function getDescfilename(){
			return $this->descfilename;
		}

		public function getDownloadpack(){
			return $this->downloadpack;
		}

		public function getProblemState(){
			return $this->problemState;
		}
		
		public function getInputFileHash(){
			return $this->probleminputfilehash;
		}

		public function setNumber($problemnumber){
			$this->problemnumber = $problemnumber;
		}

		public function setUrlinputfilename($urlinputfilename){
			$this->urlinputfilename = $urlinputfilename;
		}

		public function setInputfilename($probleminputfilename){
			$this->probleminputfilename = $probleminputfilename;
		}

		public function setName($problemname){
			$this->problemname = $problemname;
		}

		public function setFullname($problemfullname){
			$this->problemfullname = $problemfullname;
		}

		public function setBasefilename($problembasefilename){
			$this->problembasefilename = $problembasefilename;
		}

		public function setDownloadfile($downloadfile){
			$this->downloadfile = $downloadfile;
		}

		public function setDescFileName($descfilename){
			$this->descfilename = $descfilename;
		}

		public function setDownloadpack($downloadpack){
			$this->downloadpack = $downloadpack;
		}

		public function setProblemState($problemState){
			$this->problemState = $problemState;
		}
		
		public function setInputFileHash($probleminputfilehash){
			$this->probleminputfilehash = $probleminputfilehash;
		}


		public function save(){
			try {
            	$mdb =  DataBase::getDb('pgsql', 'bocadb', 1);
			/*	$sql = "INSERT INTO problemtable(contestnumber, problemnumber, problemname, problemfullname, problembasefilename, 
					probleminputfilename, probleminputfile, probleminputfilehash) VALUES 
					(1, ".$this->getNumber().", '".$this->getName()."', '".$this->getFullname()."', '".$this->getBasefilename()."',
					 '".$this->getInputfilename()."', '".$this->getInputfile()."', '".$this->getInputFileHash()."')";*/
				$sql = "INSERT INTO problemtable(contestnumber, problemnumber, problemname, problemfullname, problembasefilename, 
					probleminputfilename, probleminputfilehash, fake, updatetime) VALUES 
					(1, ".$this->getNumber().", '".$this->getName()."', '".$this->getFullname()."', '".$this->getBasefilename()."',
					 '".$this->getInputfilename()."', '".$this->getInputFileHash()."', 'f', 20000)";
	            $temp = $mdb->prepare($sql);
	            $temp->execute();
	            $mdb = null;
	        } catch (PDOException $e) {
	            print "¡Error!: " . $e->getMessage() . "<br/>";
	            die();
	        }
		}
		
		public function saveDesc(){
			try {
            	$mdb =  DataBase::getDb('mysql', 'descripciones', 2);
            	$number = $this->getNumber();
            	$descripcion = $this->getDescfilename();
            	//$sql = "SELECT * FROM problem_description WHERE id_ejercicio = $number";
            	//$temp = mysql_query($sql);
            	//$resultado = mysql_num_rows($temp);
            	//if($resultado == 0){
					$sql = "INSERT INTO problem_description(id_ejercicio, descripcion) VALUES ($number, '$descripcion')";
				//}else{
					//$sql = "UPDATE TABLE problem_description SET descripcion = $descipcion WHERE id_ejercicio = $number";
				//}
	            $temp = $mdb->prepare($sql);
	            $temp->execute();
	            //echo $mdb;
	            $mdb = null;
	        } catch (PDOException $e) {
	            print "¡Error!: " . $e->getMessage() . "<br/>";
	            die();
	        }
		}

		public static function getProblem($number){
			try {
            	$mdb =  BaseDato::getDb('pgsql', 'bocadb', 1);
            	$sql = "SELECT * FROM problemstable WHERE number = $number";
	            $temp = $mdb->prepare($sql);
	            $temp->execute();
	            $resultado = $temp->fetchAll();
	            $problem = new Problema($resultado[0]['problemnumber'],$resultado[0]['problemname'], $resultado[0]['problemfullname']);
	            $mdb = null;
	        } catch (PDOException $e) {
	            print "¡Error!: " . $e->getMessage() . "<br/>";
	            die();
	        }

	        return $problem;
		}
		
		public static function getProblemDescripcion(){
			try {
            	$mdb =  BaseDato::getDb('mysql', 'descripciones', 2);
            	$sql = "SELECT * FROM problemstable WHERE id_ejercicio = $number";
	            $temp = $mdb->prepare($sql);
	            $temp->execute();
	            $resultado = $temp->fetchAll();
	            $problem = new Problema($resultado[0]['id_ejercicio'],$resultado[0]['descripcion']);
	            $mdb = null;
	        } catch (PDOException $e) {
	            print "¡Error!: " . $e->getMessage() . "<br/>";
	            die();
	        }

	        return $problem;
		}
	}

	$temp = new Problema(15);
	$temp->setName('Probando2');
	//$temp->save();
	$temp->setDescfilename('asdasdasdasdasdasdas');
	$temp->saveDesc();
	echo "listo";
?>
