<?php
    elgg_register_event_handler('init', 'system', 'tap_init');

    function tap_init() {   
        $funcion = 'tap_page_handler';
        if(isset($_REQUEST['c']))
            $funcion = ($_REQUEST['c'] . "_page_handler");
		elgg_register_page_handler('tap', $funcion);
    }

    function tap_page_handler() {
		if(elgg_is_admin_logged_in()){
			$listado = require_once("/var/www/html/run/ejercicios.php");
			$params = cargaArray('Torneo Argentino de Programación', $listado, '');        
			include('body.php');          
		}else{
			$listado = "No tienes permiso";
			$params = cargaArray('Torneo Argentino de Programación', $listado, '');        
			include('body.php');         
			
			
		}
		
    }
	
    function ejercicio_page_handler() {   
        if(isset($_REQUEST['num']))
            $num = ($_REQUEST['num']);
        $params = cargaArray('Torneo Argentino de Programación', getEjercicio($num), '');
        include('body.php');
    }

    function cargaArray($title, $content, $filter){
        $aux = array(
            'title' => $title,
            'content' => $content,
            'filter' => $filter,
        );
        return $aux;
    }


    function getEjercicio($num) {
        include('ejercicios.php');
        
        return
        '<form action="">'.
            'GUID del usuario que lo subio: '.$ejer[$num]['guid_us'].'<br><br>
            Ejercicio N°: '.$ejer[$num]["id_ex"].'<br><br>'
            .$ejer[$num]['descripcion'].
            ' <a>Aréa de Desarrollo:</a><br><br>
             
            Seleccione lenguaje: <br>
            <input type="radio" name="lang" value="C" checked> C<br>
            <input type="radio" name="lang" value="Java"> Java <br>
                         
            <br><br>
                          
            Seleccione el archivo: 
            <input type="file" name="archivo" id="archivo" /> <br/>
                          
            <br><br><br>
                          
            <input type="hidden" id="numEx'.$ejer[$num]["id_ex"].'" name="numEx'.$ejer[$num]["id_ex"].' value='.$ejer[$num]["id_ex"].'">
            
            <input type="submit" value="Enviar" style="width:100px; height:25px;" >
        </form>


        <form>
            <input type="submit" value="Ejercicios" href="http://localhost/elgg/tap" style="width:100px; height:25px;" >
        </form>';
    }
?>
