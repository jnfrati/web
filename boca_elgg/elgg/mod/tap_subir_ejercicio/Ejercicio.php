<?php 
	include('/var/www/html/run/config/DataBase.php');
	class Ejercicio{
		public static function getEjercicio($id){
			try{
				$mdb = DataBase::getDb('mysql', 'elggadd', 2);
				$query = "SELECT * FROM ejercicios WHERE id_ex = $id";
				$temp = $mdb->prepare($query);
				$result = $temp->execute();
				$fila = $result->fetchAll();
				$ejer = array('id_ex' => $fila[0]['id_ex'], 
							'descripcion'=>$fila[0]['descripcion'],
							'nombre'=>$fila[0]['nombre'], 
							'guid_us'=> (int) $fila[0]['guid_us']);
				$mdb = null;
			} catch(PDOException $e){
				print "ERROR!". $e->getMessage();
				die();
			}
			return $ejer;
		}
	}
?>
