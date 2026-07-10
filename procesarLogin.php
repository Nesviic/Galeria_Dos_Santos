<?php
session_start();

$identificador = trim($_POST['identificador'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';

if ($identificador === '' || $contrasena === '') {
    header('Location: login.php?status=error&msg=' . urlencode('Completá usuario y contraseña.'));
    exit;
}

$conexion = new mysqli('localhost', 'root', '', 'bdd_obras');

if ($conexion->connect_error) {
    header('Location: login.php?status=error&msg=' . urlencode('Error de conexión a la base de datos.'));
    exit;
}

$stmt = $conexion->prepare("SELECT id_usuario, nombre_usuario, contrasena, rol, baneado FROM usuarios WHERE nombre_usuario = ? OR email = ?");
$stmt->bind_param('ss', $identificador, $identificador);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
$stmt->close();
$conexion->close();

// Mensaje genérico si el usuario no existe o la contraseña no coincide,
// para no revelar si el error fue el usuario o la contraseña.
if (!$usuario || !password_verify($contrasena, $usuario['contrasena'])) {
    header('Location: login.php?status=error&msg=' . urlencode('Usuario o contraseña incorrectos.'));
    exit;
}

if ((int)$usuario['baneado'] === 1) {
    header('Location: login.php?status=error&msg=' . urlencode('Esta cuenta fue suspendida. Contactá a un administrador.'));
    exit;
}

// Credenciales correctas: iniciar sesión
$_SESSION['id_usuario'] = $usuario['id_usuario'];
$_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
$_SESSION['rol'] = $usuario['rol'];

header('Location: index.php?status=ok&msg=' . urlencode('¡Bienvenido/a, ' . $usuario['nombre_usuario'] . '!'));
exit;