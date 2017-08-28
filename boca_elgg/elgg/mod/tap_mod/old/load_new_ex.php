<?php 
        header('Refresh: 5; URL=http://localhost/elgg/tap_editor');
	   //Datos de la base de datos

       $servername = "localhost";
	     $username = "root";
	     $password = "root";
	     $dbname = "elggadd";

        //Conexion con la base de datos
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) //Si falla la conexion
            die("Falló conexión: " . mysqli_connect_error());
         
        if ($_POST['tipo'] = 2)
        {
            $query = "UPDATE ejercicios 
                      SET descripcion = '".$_POST['edit']."', 
                          guid_us = ".(int)$_POST['guid']." 
                          WHERE id_ex = ".(int)$_POST['num'].";";
        }
            
        else 
        {
            $query = "INSERT INTO ejercicios (descripcion, guid_us) 
                      VALUES ('".$_POST['edit']."', ".(int) $_POST['guid'].");";

        }
        

        //Se envia la consulta si devuelve true imprime mensaje
        if (mysqli_query($conn, $query)) 
            echo "<p>El ejercicio se guardo correctamente<p> <p>Se redireccionara en 5 segundos</p>";

        else //Si devuelve false se muestra mensaje y tipo de error
            echo "Error: " . $query . "<br>" . mysqli_error($conn);

        mysqli_close($conn);
?>

        
   
         