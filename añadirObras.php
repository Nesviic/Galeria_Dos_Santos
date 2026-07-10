<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Obras - Galería Dos Santos</title>
    <link rel="stylesheet" href="../obras/css/cargar.css">
</head>
<body>
    <header>
        <a href="index.php"><h1>Galería Dos Santos</h1></a>
    </header>

    <nav>
        <a href="añadirObras.php">Añadir Obras</a>
        <a href="verObras.php">Ver Obras</a>
        <a href="login.php">Iniciar sesión</a>
        <a href="registro.php">Registrarme</a>
    </nav>

    <main>
        <?php if (isset($_GET['status']) && isset($_GET['msg'])): ?>
            <p class="mensaje mensaje-<?php echo htmlspecialchars($_GET['status']); ?>">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </p>
        <?php endif; ?>

        <form action="carga.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="obra"><h2>Añadir Obra</h2></label>
                <input id="obra" name="obras" type="file" accept="image/*">
            </div>
            <div>
                <input type="submit" value="Añadir">
            </div>
        </form>
    </main>

    <footer>
        <p>Todos los derechos reservados a la Galería</p>
    </footer>
</body>
</html>