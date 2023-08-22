<?php

require_once 'config.php';

session_start();  // Obtenemos la sesión actual.
session_unset();  // Eliminamos todas las variables de sesión.
session_destroy();  // Destruimos la sesión.

header('Location: ../');  // Redirect para hacer login de nuevo.

?>
