<?php
	/*include('/var/www/html/elgg/mod/tap_editor/almacenar.php');*/
	require_once('/var/www/boca/src/db.php');
	
	$prob = DBGetFullProblemData(1,true);
		$formulario = "	
			<style type=\"text/css\">
				.right{float:right;}
				.left{float:left;}
			</style>
			<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>		
			<script>
				$(document).ready(function(){
	        		$(\"#fcz\").hide();					
	   				$(\"#escondefaz\").click(function(){
	        			$(\"#faz\").hide();
	        			$(\"#fcz\").show();
	    			});
	   				$(\"#escondefcz\").click(function(){
	        			$(\"#fcz\").hide();
	        			$(\"#faz\").show();
	    			});
				});



			</script>
			<script>
			require(['elgg/ckeditor'], 
				    function (elggCKEditor) 
				    {
				       	elggCKEditor.bind('.elgg-input-longtext');
				    });
			</script>
			<button id=\"escondefaz\" class='elgg-button elgg-button-action' style='float: left;'>
				Cargar Zip
			</button>
			<button id=\"escondefcz\" class='elgg-button elgg-button-action' style='float: right;'> 
				Armar Zip
			</button>


			<div style='color: red; text-align: center;'>
				<h2> CARGAR NUEVO PROBLEMA </h2>
			</div>

					<!-- Armado de un nuevo ZIP -->
					<div id='faz' style='margin-top:50px;'>
						<form  name='form2' enctype='multipart/form-data' method='post' action='/run/adminprocess.php'>
						  	<input type=hidden name='noflush' value='true' />
						  	<input type=hidden name='confirmation' value='noconfirm' />
						  	
						  	<textarea rows='10' cols='50' id='problemdesc' name='problemdesc' value='Descripcion del problema' class='elgg-input-longtext' data-editor-opts='{&quot;disabled&quot;:false,&quot;state&quot;:&quot;visual&quot;}'>
							</textarea>
			
					        <script>
					        	require([\'elgg/ckeditor\'], 
					                function (elggCKEditor) 
					                {
					                	elggCKEditor.bind(\'.elgg-input-longtext\');
					                });
					        </script>

				        		Nombre ZIP:
				        		<input type='text' name='inputfilename' value='' size='20' maxlength='20' />
				        		<br/>
				        		
				        		Número:
				          		<input type='text' name='problemnumber' size='20' maxlength='20' />
								<br/>		
								
								Nombre Corto:
				          		<input type='text' name='problemname' value='' size='20' maxlength='20' />
				          		(Usualmente una letra, sin espacios)
				          		<br/>
					        	
					        	Nombre Problema:
					          	<input type='text' name='fullname' value='' size='50' maxlength='100' />
					          	<br/>
								
								Nombre de Clase:
						        <input type='text' name='basename' value='' size='50' maxlength='100' />
						        (Alias: nombre de la clase que se espera tenga el main)
						        <br/>
							 	
							 	Archivo de Entrada:
						        <input type='file' name='probleminput' value='' size='40' />
						        <br/>

							 	Archivo de salida:
						        <input type='file' name='problemsol' value='' size='40' />
						        <br/>

						        Tiempo Limite (en seg.):			
						        <input type='text' name='timelimit' value='' size='10' />
							    (Opcional: usar una \',\' seguida por el numero de repeticiones a ejecutar)
							    <br/>

							    <button type='submit' name='Submit5' onClick='conf4()' class='elgg-button elgg-button-submit left'>
							    	Enviar
							    </button>
							    <button type='reset' name='Submit4' class='elgg-button elgg-button-cancel right'>
							    	Limpiar
							    </button>
						</form>
					</div>
					

					<div id='fcz' style='margin-top:50px;'>
						<form  name='form2' enctype='multipart/form-data' method='post' action='/run/cargazip.php'>
							
							<textarea rows='10' cols='50' id='problemdesc' name='problemdesc' value='Descripcion del problema' class='elgg-input-longtext' data-editor-opts='{&quot;disabled&quot;:false,&quot;state&quot;:&quot;visual&quot;}'>
							</textarea>
			
					        <script>

					        </script>


							Number:
							<input type='text' name='problemnumber' value='' size='20' maxlength='20' />
							<br/>

							Short Name:
							<input type='text' name='problemname' value='' size='20' maxlength='20' />
							<br/>
							
							Problem package (ZIP):
							<input type='file' name='probleminput' value='' size='40' />
							<br/>
							
							Color name:
							<input type='text' name='colorname' value='' size='40' maxlength='100' />
							<br/>
							
							Color (RGB HTML format):
							<input type='text' name='color' value='' size='6' maxlength='6' />
						    <br/>
						    <button type='submit' name='Submit5' class='elgg-button elgg-button-submit left'>
						    	Enviar
						    </button>
						    <button type='reset' name='Submit4' class='elgg-button elgg-button-cancel right'>
						    	Limpiar
						    </button>
						</form>
					</div>

		";
	return $formulario;
?>
