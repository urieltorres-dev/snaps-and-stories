<?php

// Para iniciar una nueva sesión o recuperar una sesión existente.
session_start();

$USUARIO_ID = NULL;
$USUARIO_USERNAME = NULL;
$USUARIO_EMAIL = NULL;
$USUARIO_NOMBRE = NULL;
$USUARIO_APELLIDOS = NULL;
$USUARIO_NOMBRE_COMPLETO = NULL;
$USUARIO_FOTO_PERFIL = NULL;

// Si ya tenemos un usuario logueado.
if (isset($_SESSION['Usuario_Id'])) {
    // Las variables de sesión las ponemos en variables locales para mejor uso.
    $USUARIO_ID = $_SESSION['Usuario_Id'];
    $USUARIO_USERNAME = $_SESSION['Usuario_Username'];
    $USUARIO_EMAIL = $_SESSION['Usuario_Email'];
    $USUARIO_NOMBRE = $_SESSION['Usuario_Nombre'];
    $USUARIO_APELLIDOS = $_SESSION['Usuario_Apellidos'];
    $USUARIO_NOMBRE_COMPLETO = 
            $USUARIO_APELLIDOS ? "$USUARIO_NOMBRE $USUARIO_APELLIDOS" : $USUARIO_NOMBRE;
    $USUARIO_FOTO_PERFIL = $_SESSION['Usuario_Foto_Perfil'];
}

?>
