<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: index.php?status=ok&msg=' . urlencode('Sesión cerrada correctamente.'));
exit;