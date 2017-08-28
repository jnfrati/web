<?php
	
    elgg_register_event_handler('init', 'system', 'tap_delete_init');

    function tap_delete_init() {   
        $funcion = 'tap_delete_page_handler';
        if(isset($_REQUEST['c']))
            $funcion = ($_REQUEST['c'] . "_page_handler");
		elgg_register_page_handler('tap_delete', $funcion);
    }

    function tap_delete_page_handler() {
		include('/var/www/html/run/config/DataBase.php');
        $number = base64_decode($_REQUEST['n']);
        try{
			$mdb = DataBase::getDb('pgsql', 'bocadb', 1);
			$sql = "DELETE FROM problemtable WHERE problemnumber = $number";
			$temp = $mdb->prepare($sql);
			$temp->execute();
			$mdb = null;
		} catch(PDOException $e){
			print "error" . $e->getMessage();
			die();
		}
        $formulario=null;
        $params = cargaArray2('Se elimino el ejercicio seleccionado', $fomulario, '');        
        include('body.php');          
        sleep(5);
        echo "<script language=\"JavaScript\">\n";
		echo "document.location='/elgg/tap';\n";
		echo "</script>\n";
    }	

    function cargaArray2($title, $content, $filter){
        $aux = array(
            'title' => $title,
            'content' => $content,
            'filter' => $filter,
        );
        return $aux;
    }

?>
