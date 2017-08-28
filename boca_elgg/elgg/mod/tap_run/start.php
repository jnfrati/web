<?php

    elgg_register_event_handler('init', 'system', 'tap_run_init');


    function tap_run_init() 
    {
            $funcion = 'tap_run_page_handler';
            elgg_register_page_handler('tap_run', $funcion);
    }



    //Para ver la pagina con el listado de ejercicios.
    function tap_run_page_handler() 
    {
        include("/var/www/html/run/tap_run.php");
        
        $params = cargaArray('Torneo Argentino de Programación', $form, '');
        
        include('body.php');   
    }

?>