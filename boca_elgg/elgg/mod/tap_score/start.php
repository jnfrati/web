<?php

    elgg_register_event_handler('init', 'system', 'tap_score_init');


//Widget functions
        function hello_init() {
            elgg_register_widget_type('helloworld', 'Hello, world!', 'The "Hello, world!" widget');
        }

        elgg_register_event_handler('init', 'system', 'hello_init');




//Plugin functions
    function tap_score_init() 
    {
            $funcion = 'tap_score_page_handler';
            elgg_register_page_handler('tap_score', $funcion);
    }



    //Para ver la pagina con el listado de ejercicios.
    function tap_score_page_handler() 
    {
        


        $listado = (include("/var/www/html/run/tablaScore.php"));
       // echo "Hola";
        //exit;
        $params = cargaArray3('Torneo Argentino de Programación', $listado, '');


        
        include('body.php');  
                //Incluye el contenido en la vista    
        
        
        

        
    }



    //Carga array del contenido de la pagina a mostrar
    function cargaArray3($title, $content, $filter)
    {
        $aux = array(
            'title' => $title,
            'content' => $content,
            'filter' => $filter,
        );
        return $aux;
    }





?>