<?php

var_dump($_FILES);

if (isset($_FILES['obras'])) {
    print "<ul>
                <li>Nombre: ". $_FILES['obras']['name'] ."</li>
                <li>Tipo de archivo: ". $_FILES['obras']['type'] ."</li>
                <li>Nombre temporal: ". $_FILES['obras']['tmp_name'] ."</li>
                <li>Errores: ". $_FILES['obras']['error'] ."</li>
                <li>Peso: ". $_FILES['obras']['size'] ."</li>
            </ul>";

    $temporal = $_FILES['obras']['tmp_name'];
    $nombre = $_FILES['obras']['name'];

    $directorioDestino = __DIR__ . '/obras de arte/';

    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);  
    }

    if (move_uploaded_file($temporal, $directorioDestino . $nombre)) {
        echo "<p>Archivo subido exitosamente.</p>";

        $conexion = new mysqli('localhost', 'root', '', 'bdd_obras');

        if ($conexion->connect_error) {
            die("<p>Error de conexión a la base de datos: " . $conexion->connect_error . "</p>");
        }
        
        $nombreEscapado = $conexion->real_escape_string($nombre);
        $ruta = 'obras_de_arte/' . $nombreEscapado;

        $sql = "INSERT INTO obra_arte (ruta) VALUES ('$ruta')";

        if ($conexion->query($sql) === TRUE) {
            echo "<p>Datos guardados en la base de datos.</p>";
        } else {
            echo "<p>Error al guardar en la base de datos: " . $conexion->error . "</p>";
        }

        $conexion->close();

    } else {
        echo "<p>Error al mover el archivo.</p>";
    }

} else {
    print "No se ha subido ningún archivo.";
}

print "<figure> 
            <img src='obras de arte/$nombre' alt='$nombre'>        
        </figure>";

?>