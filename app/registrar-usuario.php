<?php

require_once '../helpers/config.php';
require_once APP_PATH . 'helpers/db.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$now = new DateTime();  // Objeto DateTime que representa la fecha-hora actual.
$resObj = ["error" => NULL, "mensaje" => NULL];  // Assoc array con los datos que regresaremos.

// Datos del usuario que vamos a guardar.
$username = filter_input(INPUT_POST, "username");
$email = filter_input(INPUT_POST, "email");
$passwordPlainText = filter_input(INPUT_POST, "password");
$nombre = filter_input(INPUT_POST, "nombre");
$apellidos = filter_input(INPUT_POST, "apellidos");
$genero = filter_input(INPUT_POST, "genero");

// Validamos que los datos obligatorios no estén vacíos.
if(empty($username) || empty($email) || empty($passwordPlainText) || empty($nombre)){
    $resObj["error"] = "Debe proporcionar los datos obligatorios";
    echo json_encode($resObj);
    exit;   // termina la ejecución.
}

// Por seguridad, NUNCA se GUARDA la CONTRASEÑA en TEXTO PLANO. Por esto se
// GUARDA un HASH (cifrado de una sola vía) que representa la contraseña.
$passwordSalt = strtoupper(bin2Hex(random_bytes(16)));   // Random Salt
$passwordMasSalt = $passwordPlainText . $passwordSalt;
$passwordHashed = strtoupper(hash("sha512", $passwordMasSalt));

// Se obtiene el objeto PDO que es con el que vamos a interactuar con DB.
$db = getDbConnection();

// La sentencia SQL con la que vamos a consultar si el usuario esta disponible.
$sqlCmdSelectUsuario = 
    "SELECT * FROM usuarios " .
    "    WHERE username = ?";  // <- Placeholders de los datos que vamos a enviar en la sentencia SQL.

// Los datos que vamos a enviar con la sentencia SQL. Estos datos tienen que ir en
// orden según el placeholder en la sentencia SQL.
$params = [
    $username
];

// Obtenemos el objeto Statement que representa la ejecución de la sentencia SQL.
$stmt = $db->prepare($sqlCmdSelectUsuario);

// Ejecutamos el statement con los parámetros correspondientes.
$stmt-> execute($params);

// Obtenemos el resultado de la consulta.
$nombreDeUsuarioEsiste = $stmt->fetch();

// Validamos si el nombre de usuario esta disponible
if($nombreDeUsuarioEsiste){
    $resObj["error"] = "El nombre de usuario no esta disponible.";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Validar que el username tenga una longitud mínima de 2 caracteres
if (strlen($username) < 2) {
    $resObj["error"] = "El nombre de usuario debe tener al menos 2 caracteres.";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Validar que el username empiece con una letra minúscula
if (!preg_match('/^[a-z]/', $username)) {
    $resObj["error"] = "El username debe empezar con una letra minúscula";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Validar que el username solo contenga letras minúsculas, números y guiones bajos
if (!preg_match('/^[a-z0-9_]+$/', $username)) {
    $resObj["error"] = "El username solo puede contener letras minúsculas, números y guiones bajos";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Validamos que la password tenga una longitud mínima de 6 caracteres.
if (strlen($passwordPlainText) < 6) {
    $resObj["error"] = "La contraseña debe tener al menos 6 caracteres";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Se obtiene el objeto PDO que es con el que vamos a interactuar con DB.
$db2 = getDbConnection();

// La sentencia SQL con la que vamos a insertar los datos.
$sqlCmdInsertUsuario = 
    "INSERT INTO usuarios " .
    "        (username, email, password, password_salt, nombre, apellidos, " .
    "         genero, fecha_hora_registro, activo)" .
    "    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";  // <- Placeholders de los datos que vamos a enviar en la sentencia SQL.

// Los datos que vamos a enviar con la sentencia SQL. Estos datos tienen que ir en
// orden según el placeholder en la sentencia SQL.
$params2 = [
    $username, 
    $email,
    $passwordHashed, 
    $passwordSalt, 
    $nombre, 
    $apellidos, 
    $genero, 
    $now->format("Y-m-d H:i:s"),  // Es común enviar las fechas en formato 0000-00-00 00:00:00
    1
];

// Obtenemos el objeto Statement que representa la ejecución de la sentencia SQL.
$stmt2 = $db2->prepare($sqlCmdInsertUsuario);

// Ejecutamos el statement con los parámetros correspondientes.
$stmt2-> execute($params2);

// Obtenemos el Id del último registro insertado con la función lastInsertId.
$idInserted = (int)$db2->lastInsertId();

if($idInserted == NULL){
    $resObj["error"] = "Registro Fallido";
}else{
    // Mensaje que queremos regresar.
    $resObj["mensaje"] = "Registro exitoso";
}

// El array asociativo lo convertimos a un string JSON y esa va a ser la respuesta.
echo json_encode($resObj);

?>
