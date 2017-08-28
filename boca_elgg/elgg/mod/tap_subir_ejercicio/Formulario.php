<?php
include('/var/www/html/run/config/DataBase.php');
        $user = elgg_get_logged_in_user_entity();
		$id = $_REQUEST['numero'];
		//$form = Formulario::getFormulario($num);  
		$guid = $_SESSION[_sf2_attributes][guid];
		$user = get_user($guid);
		//$ejer = Ejercicio::getEjercicio($id);
		$userProb = get_user($ejer['guid_us']);		
		try{
			$mdb = DataBase::getDb('mysql', 'elggadd', 2);
			$query = "SELECT * FROM ejercicios WHERE id_ex = $id";
			$temp = $mdb->prepare($query);
			$temp->execute();
			$fila = $temp->fetchAll();
			
			$ejer = array('id_ex' => $fila[0]['id_ex'], 
						'descripcion'=>$fila[0]['descripcion'],
						'nombre'=>$fila[0]['nombre'], 
						'guid_us'=> (int) $fila[0]['guid_us']);
			$mdb = null;
		} catch(PDOException $e){
			print "ERROR!". $e->getMessage();
			die();
		}
		//var_dump($site);
		
		
		$form =
		"
			<body>

			<style>div{align-content: center;}</style>
			<form action='http://".$_SERVER['HTTP_HOST']."/run/runSave.php' method='post' enctype='multipart/form-data'>
				<div align='center'>
					<b>Ejercicio ".$ejer['nombre'].
					"</b><br><br>"
					.$ejer['descripcion'].
					"<br><br>
					Seleccione lenguaje: 
					<br>
					
					<select name='language' class='elgg-button elgg-button-special elgg-button-dropdown'>
						<option value='C'>C</option>
						<option value='Java'>Java</option>
					</select>
					
					<br><br><br>
					Seleccione el archivo: 
					<br>

					<input type='file' name='sourcefile' class='elgg-button elgg-button-special'>
				
					
					<br/>
					<input type='hidden' id='problem' name='problem' value=".$_GET['numero'].">
					<input type='hidden' id='usernumber' name='usernumber' value=".$guid.">
				</div>
						<button style='float:left;' type='submit' value='Enviar' class='elgg-button elgg-button-submit' >
							Enviar
						</button>
						<a href='http://".$_SERVER['HTTP_HOST']."/elgg/tap_sol'>
						<button style='float: right;' type='button' value='Cancelar' class='elgg-button elgg-button-cancel'>Cancelar</button>
						</a>


				
			</form>
			<br/>
			<br/>
			<br/>
			<div align='center'>
			<form action='http://".$_SERVER['HTTP_HOST']."/run/template.php' method='post' >
				Descargar plantilla
					<select name='language' class='elgg-button elgg-button-special elgg-button-dropdown'>
						<option value='C'>C</option>
						<option value='Java'>Java</option>
					</select>
					<input type='hidden' id='problem' name='problem' value=".$ejer['nombre'].">
				<button type='submit'>Descargar</button>
					
			</form>
			</div>

			<a href='".$_SERVER['HTTP_HOST']."'><button>URL</button></a>

			</body>";
?>
