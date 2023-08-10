<?php

// Archivos de código necesarios para la ejecución de esta página.
require_once "../helpers/config.php";
require_once APP_PATH . "helpers/db.php";
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$resObj = ["error" => NULL, "username" => $USUARIO_USERNAME];  // Assoc array de los datos que regresaremos somo JSON.

// Obtenemos los datos del formulario.
$nombre = filter_input(INPUT_POST, "nombre");
$apellidos = filter_input(INPUT_POST, "apellidos");
$email = filter_input(INPUT_POST, "email");
$genero = filter_input(INPUT_POST, "genero");

// Si no se recibió el nombre, regresamos un error.
if (!$nombre) {
    $resObj["error"] = "No se recibió el nombre.";
    echo json_encode($resObj);
    exit;
}

// Si no se recibió el email, regresamos un error.
if (!$email) {
    $resObj["error"] = "No se recibió el email.";
    echo json_encode($resObj);
    exit;
}

// Se obtiene el objeto PDO que es con el que vamos a interactuar con DB.
$db = getDbConnection();

// Se prepara la sentencia SQL para actualizar el usuario.
$sqlCmd = "UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, genero = ? WHERE id = ? AND activo = 1";
$sqlParams = [$nombre, $apellidos, $email, $genero, $USUARIO_ID];

// Se ejecuta la sentencia SQL.
$stmt = $db->prepare($sqlCmd);
$stmt->execute($sqlParams);

// Se regresa el resultado de la operación.
echo json_encode($resObj);

?>
