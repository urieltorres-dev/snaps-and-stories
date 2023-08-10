<?php

// Archivos de código necesarios para la ejecución de esta página.
require_once "../helpers/config.php";
require_once APP_PATH . "helpers/db.php";
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$resObj = ["error" => NULL];  // Assoc array de los datos que regresaremos somo JSON.

$currentPasswordPlainText = filter_input(INPUT_POST, "contraseña-actual"); // Contraseña en texto plano.
$newPasswordPlainText = filter_input(INPUT_POST, "contraseña-nueva"); // Contraseña en texto plano.

// Si no se recibió la contraseña actual, regresamos un error.
if (!$currentPasswordPlainText) {
    $resObj["error"] = "No se recibió la contraseña actual.";
    echo json_encode($resObj);
    exit;
}

// Si no se recibió la contraseña nueva, regresamos un error.
if (!$newPasswordPlainText) {
    $resObj["error"] = "No se recibió la contraseña nueva.";
    echo json_encode($resObj);
    exit;
}

// Validamos que la password tenga una longitud mínima de 6 caracteres.
if (strlen($newPasswordPlainText) < 6) {
    $resObj["error"] = "La contraseña debe tener al menos 6 caracteres.";
    echo json_encode($resObj);
    exit;
}

$sqlCmd =   // SQL Command SELECT para consultar el usuario por el username.
        "SELECT id, username, email, password, password_salt, nombre, apellidos,  activo " .
        "    FROM usuarios WHERE username = ? ORDER BY id DESC";
$sqlParams = [$USUARIO_USERNAME];  // Parámetros a enviar en la consulta.
    
// Ejecución de la sentencia SQL con la base de datos.
$db = getDbConnection();  // Obtenemos la conexión a la base de datos (objeto PDO).
$stmt = $db->prepare($sqlCmd);  // Obtenemos el Statement de la sentencia SQL.
$stmt->execute($sqlParams);  // Ejecutamos el Statment con los parámetros (solo username)
$r = $stmt->fetchAll();  // Obtenemos un array de assoc array de los registros encontrados.

// Si no se regresó ninguna coincidencia (consultando por el username)
// se regresa un error.
if (!$r) {
    $resObj["error"] = "No se encontró el usuario.";
    echo json_encode($resObj);
    exit;
}

// Obtenemos el registro del usuario de los resultados de la consulta.
// Si el usuario no está activo, regresamos un error.
$usuario = $r[0];
if (!$usuario["activo"]) {
    $resObj["error"] = "El usuario no está activo.";
    echo json_encode($resObj);
    exit;
}

// Obtenemos la contraseña encriptada del usuario.
$usuarioPassword = $usuario["password"];

// Obtenemos el salt de la contraseña del usuario.
$usuarioPasswordSalt = $usuario["password_salt"];

// Obtenemos la contraseña encriptada de la contraseña actual.
$currentPasswordEncrypted = strtoupper(hash("sha512", $currentPasswordPlainText . $usuarioPasswordSalt));

// Si la contraseña encriptada de la contraseña actual no coincide con la contraseña encriptada
// del usuario, regresamos un error.
if ($currentPasswordEncrypted !== $usuarioPassword) {
    $resObj["error"] = "La contraseña actual no coincide.";
    echo json_encode($resObj);
    exit;
}

// Obtenemos un salt aleatorio para la nueva contraseña.
$newPasswordSalt = strtoupper(bin2Hex(random_bytes(16)));   // Random Salt

// Obtenemos la contraseña encriptada de la nueva contraseña.
$newPasswordEncrypted = strtoupper(hash("sha512", $newPasswordPlainText . $newPasswordSalt));

// SQL Command UPDATE para actualizar la contraseña del usuario.
$sqlCmd = "UPDATE usuarios SET password = ?, password_salt = ? WHERE id = ?";
$sqlParams = [$newPasswordEncrypted, $newPasswordSalt, $usuario["id"]];  // Parámetros a enviar en la consulta.

// Ejecución de la sentencia SQL con la base de datos.
$db = getDbConnection();  // Obtenemos la conexión a la base de datos (objeto PDO).
$stmt = $db->prepare($sqlCmd);  // Obtenemos el Statement de la sentencia SQL.
$stmt->execute($sqlParams);  // Ejecutamos el Statment con los parámetros (solo username)

// Si no se pudo actualizar la contraseña, regresamos un error.
if ($stmt->rowCount() !== 1) {
    $resObj["error"] = "No se pudo actualizar la contraseña.";
    echo json_encode($resObj);
    exit;
}

// Enviamos la respuesta como JSON.
echo json_encode($resObj);

?>