<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Obras - Galería Dos Santos</title>
    <link rel="stylesheet" href="../obras/css/verObras.css">
</head>
<body>
    <header>
        <a href="index.php"><h1>Galería Dos Santos</h1></a>
    </header>

    <nav>
        <div class="nav-principal">
            <a href="añadirObras.php">Añadir Obras</a>
            <a href="verObras.php">Ver Obras</a>
        </div>
        <div class="nav-cuenta">
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <span class="nav-saludo">Hola, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                <a href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
                <a href="registro.php" class="btn-registro">Registrarme</a>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <section class="gallery">
            <?php
            $conexion = new mysqli('localhost', 'root', '', 'bdd_obras');
            if ($conexion->connect_error) {
                die("<p>Error de conexión: " . $conexion->connect_error . "</p>");
            }

            $sql = "SELECT ruta FROM obra_arte";
            $resultado = $conexion->query($sql);

            if (!$resultado) {
                die("Error en la consulta SQL: " . $conexion->error);
            }

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<div class='obra'><img src='" . $fila['ruta'] . "'></div>";
                }
            } else {
                echo "<p>No hay obras subidas aún.</p>";
            }

            $conexion->close();
            ?>
        </section>
    </main>

    <footer>
        <p>Todos los derechos reservados a la Galería</p>
    </footer>
</body>
</html>