<?php

require_once "config.php";
require_once APP_PATH . "helpers/sesion.php";

// Validamos que esté establecida variable de sesión, así sabemos si está autenticado.
if (!isset($_SESSION['Usuario_Id'])) {
    header('Location: ' . APP_PATH);
    exit;
}

?>
