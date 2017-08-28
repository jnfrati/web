<?php

	function getForm($guid)
	{
		//Editor de texto 
	    $editor = 
			'<textarea rows="10" cols="50" id="edit" name="edit" class="elgg-input-longtext" data-editor-opts="{&quot;disabled&quot;:false,&quot;state&quot;:&quot;visual&quot;}">
			</textarea>
			
	        <script>
	        	require([\'elgg/ckeditor\'], 
	                function (elggCKEditor) 
	                {
	                	elggCKEditor.bind(\'.elgg-input-longtext\');
	                });
	        </script>';

	    //Formulario
	    return
			'<form action="mod/tap_editor/load_new_ex.php" method="post">
	                    
				<a>Ingrese un nuevo problema:</a><br><br>
				  '.$editor.'
				  <br><br><br><br>
				  <input type="hidden" id="guid" name="guid" value="'.$guid.'">
				  <input type="submit" value="Cargar"/>
	        </form>';
    }
?>