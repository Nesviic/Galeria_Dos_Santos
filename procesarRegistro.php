<?php

$nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
$email = trim($_POST['email'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

// --- Validaciones básicas ---
if ($nombre_usuario === '' || $email === '' || $contrasena === '' || $confirmar_contrasena === '') {
    header('Location: registro.php?status=error&msg=' . urlencode('Completá todos los campos.'));
    exit;
}

if (strlen($contrasena) < 6) {
    header('Location: registro.php?status=error&msg=' . urlencode('La contraseña debe tener al menos 6 caracteres.'));
    exit;
}

if ($contrasena !== $confirmar_contrasena) {
    header('Location: registro.php?status=error&msg=' . urlencode('Las contraseñas no coinciden.'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?status=error&msg=' . urlencode('El email no es válido.'));
    exit;
}

$conexion = new mysqli('localhost', 'root', '', 'bdd_obras');

if ($conexion->connect_error) {
    header('Location: registro.php?status=error&msg=' . urlencode('Error de conexión a la base de datos.'));
    exit;
}

// --- Verificar que el usuario o el email no existan ya ---
$stmtVerificar = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE nombre_usuario = ? OR email = ?");
$stmtVerificar->bind_param('ss', $nombre_usuario, $email);
$stmtVerificar->execute();
$resultadoVerificar = $stmtVerificar->get_result();

if ($resultadoVerificar->num_rows > 0) {
    $stmtVerificar->close();
    $conexion->close();
    header('Location: registro.php?status=error&msg=' . urlencode('Ese nombre de usuario o email ya está registrado.'));
    exit;
}
$stmtVerificar->close();

// --- Hashear la contraseña (nunca se guarda en texto plano) ---
$contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

// --- Insertar el nuevo usuario (rol "comun" por defecto, no baneado) ---
$stmtInsertar = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, email, contrasena, rol, baneado) VALUES (?, ?, ?, 'comun', 0)");
$stmtInsertar->bind_param('sss', $nombre_usuario, $email, $contrasenaHasheada);

if ($stmtInsertar->execute()) {
    $stmtInsertar->close();
    $conexion->close();
    header('Location: login.php?status=ok&msg=' . urlencode('Cuenta creada con éxito. Ya podés iniciar sesión.'));
    exit;
} else {
    $stmtInsertar->close();
    $conexion->close();
    header('Location: registro.php?status=error&msg=' . urlencode('Error al crear la cuenta. Intentá de nuevo.'));
    exit;
}