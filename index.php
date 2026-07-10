<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería Dos Santos</title>
    <link rel="stylesheet" href="../obras/css/styles.css">
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
        <?php if (isset($_GET['status']) && isset($_GET['msg'])): ?>
            <p class="mensaje mensaje-<?php echo htmlspecialchars($_GET['status']); ?>">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </p>
        <?php endif; ?>

    <div class="fondo">
            <h1>Galería Dos Santos</h1>
        </div>

    </main>

    <footer>
        <p>Todos los derechos reservados a la Galería</p>
    </footer>
</body>
</html>