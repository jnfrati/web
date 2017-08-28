<?php

    elgg_register_event_handler('init', 'system', 'tap_mod_init');


    //elgg_register_page_handler le dice a elgg que debe llamar a la funcion ..._page_handler cuando el usuario vaya al sitio localhost/elgg/...
    function tap_mod_init() 
    {
        $funcion = 'mod_page_handler';
        elgg_register_page_handler('tap_mod', $funcion);
    }
    
    

    function mod_page_handler() 
    {
        if(!isset($_REQUEST['num']) || $_REQUEST['num'] == '')
        {
            $form = require_once("/var/www/html/run/admin.php");
            $params = cargaArray('Torneo Argentino de Programación', $form, '');
        }

        else
        {
            /*$params = cargaArray('Torneo Argentino de Programación', 
                                getForm($_SESSION[_sf2_attributes][guid], buscarEjercicio($_REQUEST['num'])), 
                                '');*/
            $params = cargaArray('Torneo Argentino de Programación', 
                                'Fomulario','');
        }
        include('body.php');    
    }




/*
    function getForm($guid, $contenido)
    {
        //Editor de texto 
        $editor = 
            '<textarea rows="10" cols="50" id="edit" name="edit" class="elgg-input-longtext" data-editor-opts="{&quot;disabled&quot;:false,&quot;state&quot;:&quot;visual&quot;}">
            '.$contenido.'
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
                  <input type="hidden" id="tipo" name="tipo" value="'.$_REQUEST['tipo'].'">
                  <input type="hidden" id="num" name="num" value="'.$_REQUEST['num'].'">
                  <input type="submit" value="Cargar"/>
            </form>';
    }


    function buscarEjercicio($num) 
    {
        include('/var/www/html/elgg/mod/tap/ejercicios.php');
        return $ejer[$num]['descripcion'];
    }
*/

?>
