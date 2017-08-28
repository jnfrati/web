<?php
    elgg_register_event_handler('init', 'system', 'tap_sol_init');
    
    function tap_sol_init() {
        $funcion = 'sol_page_handler';
        elgg_register_page_handler('tap_sol', $funcion);
    }
    
    function sol_page_handler() {
        $user = elgg_get_logged_in_user_entity();
		$num = 1;
		$form = require_once('listado.php');  
        $params = cargaArray('Torneo Argentino de Programación', $form, '');
        include('body.php');
    }
?>
