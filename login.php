<?php
session_start();

// Si ya está logueado, no tiene sentido mostrar el formulario de nuevo
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Galería Dos Santos</title>
    <link rel="stylesheet" href="../obras/css/cargar.css">
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
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php" class="btn-registro">Registrarme</a>
        </div>
    </nav>

    <main>
        <?php if (isset($_GET['status']) && isset($_GET['msg'])): ?>
            <p class="mensaje mensaje-<?php echo htmlspecialchars($_GET['status']); ?>">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </p>
        <?php endif; ?>

        <form action="procesarLogin.php" method="post">
            <div>
                <label for="identificador"><h2>Iniciar sesión</h2></label>
            </div>
            <div>
                <label for="identificador">Usuario o email</label>
                <input id="identificador" name="identificador" type="text" required>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input id="contrasena" name="contrasena" type="password" required>
            </div>
            <div>
                <input type="submit" value="Ingresar">
            </div>
        </form>
    </main>

    <footer>
        <p>Todos los derechos reservados a la Galería</p>
    </footer>
</body>
</html>