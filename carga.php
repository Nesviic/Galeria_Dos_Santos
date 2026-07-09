<?php

$status = 'error';
$mensaje = 'No se ha subido ningún archivo (o hubo un error en la subida).';

if (isset($_FILES['obras']) && $_FILES['obras']['error'] === UPLOAD_ERR_OK) {

    $temporal = $_FILES['obras']['tmp_name'];
    $nombre = $_FILES['obras']['name'];

    // Nombre de carpeta unificado (sin espacios) para que coincida con la ruta guardada en la BD
    $nombreCarpeta = 'obras_de_arte';
    $directorioDestino = __DIR__ . '/' . $nombreCarpeta . '/';

    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    if (move_uploaded_file($temporal, $directorioDestino . $nombre)) {

        $conexion = new mysqli('localhost', 'root', '', 'bdd_obras');

        if ($conexion->connect_error) {
            $mensaje = 'Error de conexión a la base de datos: ' . $conexion->connect_error;
        } else {
            $nombreEscapado = $conexion->real_escape_string($nombre);
            $ruta = $nombreCarpeta . '/' . $nombreEscapado;

            $sql = "INSERT INTO obra_arte (ruta) VALUES ('$ruta')";

            if ($conexion->query($sql) === TRUE) {
                $status = 'ok';
                $mensaje = 'Obra subida y guardada correctamente.';
            } else {
                $mensaje = 'Error al guardar en la base de datos: ' . $conexion->error;
            }

            $conexion->close();
        }

    } else {
        $mensaje = 'Error al mover el archivo.';
    }
}

header('Location: añadirObras.php?status=' . $status . '&msg=' . urlencode($mensaje));
exit;