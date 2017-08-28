<?php
    elgg_register_event_handler('init', 'system', 'tap_editor_init');
	
    function tap_editor_init() {
        $funcion = 'editor_page_handler';
        elgg_register_page_handler('tap_editor', $funcion);
    }

    function editor_page_handler() {		
		if(elgg_is_admin_logged_in()){
			$number = base64_decode($_REQUEST['n']);
			$name = base64_decode($_REQUEST['na']);
			$fullname = base64_decode($_REQUEST['fu']);
			$basefilename = base64_decode($_REQUEST['ba']);
			$descfilename = base64_decode($_REQUEST['de']);
			if($number != null){
				$form = "
				<table>
					<tr>
						<td>
							<div style='color: red; text-align: center;'>
								<h2> CARGAR NUEVO PROBLEMA </h2>
							</div>
						</td>
					</tr>

					<tr>
						<td>
						<!-- Armado de un nuevo ZIP -->
							<form style='float: right;' name='form2' enctype='multipart/form-data' method='post' action='/run/adminprocess.php'>
								<input type=hidden name='noflush' value='true' />
								<input type=hidden name='confirmation' value='noconfirm' />
								
								<textarea rows='10' cols='50' id='problemdesc' name='problemdesc' value='Descripcion del problema' class='elgg-input-longtext' data-editor-opts='{&quot;disabled&quot;:false,&quot;state&quot;:&quot;visual&quot;}'>
								</textarea>
				
								<script>
									require(['elgg/ckeditor'], 
										function (elggCKEditor) 
										{
											elggCKEditor.bind('.elgg-input-longtext');
										});
								</script>


								<center>
									<table border='0'>
										<tr>
											<td width='35%' align=right>Nombre ZIP:</td>
											<td width='65%'>
												<input type='text' name='inputfilename' value='' size='20' maxlength='20' />
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Número:</td>
											<td width='65%'>
												<input type='text' name='problemnumber' value='$number' size='20' maxlength='20' />
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Nombre Corto:</td>
											<td width='65%'>
												<input type='text' name='problemname' value='$name' size='20' maxlength='20' />
												(Usualmente una letra, sin espacios)
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Nombre Problema:</td>
											<td width='65%'>
												<input type='text' name='fullname' value='$fullname' size='50' maxlength='100' />
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Nombre de Clase:</td>
											<td width='65%'>
												<input type='text' name='basename' value='$basefilename' size='50' maxlength='100' />
												(Alias: nombre de la clase que se espera tenga el main)
											</td>
										</tr>

										<tr>
											<td width='35%' align=right>Archivo de Entrada:</td>
											<td width='65%'>
												<input type='file' name='probleminput' value='' size='40' />
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Archivo de salida:</td>
											<td width='65%'>
												<input type='file' name='problemsol' value='' size='40' />
											</td>
										</tr>
										<tr>
											<td width='35%' align=right>Tiempo Limite (en seg.):</td>
											<td width='65%'>
												<input type='text' name='timelimit' value='' size='10' />

												(Opcional: usar una \',\' seguida por el numero de repeticiones a ejecutar)
											</td>
										</tr>
									</table>
								</center>
								
								<center>
									<input type='submit' name='Submit5' value='Enviar' onClick='conf4()'>
									<input type='reset' name='Submit4' value='Limpiar'>
								</center>
								
							</form>
						</td>
					</tr>
				</table>
			";
			}else{
				$form = require_once("/var/www/html/run/admin.php");
			}
			$params = cargaArray('Torneo Argentino de Programación', $form, '');
			include('body.php');    
		}else{
			$form = "No tienes permiso";
			$params = cargaArray('Torneo Argentino de Programación', $form, '');
			include('body.php');    
		}
		
    }
?>
