<?php
    elgg_register_event_handler('init', 'system', 'tap_subir_ejercicio_init');
    
    function tap_subir_ejercicio_init() {
        $funcion = 'subir_ejercicio_page_handler';
        elgg_register_page_handler('tap_subir_ejercicio', $funcion);
    }
    
    function subir_ejercicio_page_handler() {
		include('Formulario.php');
		//include('Ejercicio.php');
		
        $params = cargaArray('Torneo Argentino de Programación', $form, '');
        include('body.php');
    }
?>
