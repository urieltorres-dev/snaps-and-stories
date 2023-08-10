<?php

require_once '../helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$resObj = ["error" => NULL, "mensaje" => NULL];  // Assoc array con los datos que regresaremos.

// Es recomendable usar la función filter_input para obtener los valores recibidos
// dentro de la petición POST (también aplica para variables URL, lo que está en $_GET)
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

/**
 * Función con la que validamos el usuario por su username y password. Si no se validan
 * los datos, regresara un false, en caso de que se valide correctamente el usuario,
 * regresara un assoc array con los datos del usuario.
 */
function autentificar($username, $password) {
    
    // Si no nos han enviado los parámetros, regresamos false.
    if (!$username || !$password) return false;

    $sqlCmd =   // SQL Command SELECT para consultar el usuario por el username.
        "SELECT * FROM usuarios WHERE username = ? ORDER BY id DESC";
    $sqlParams = [$username];  // Parámetros a enviar en la consulta.
    
    // Ejecución de la sentencia SQL con la base de datos.
    $db = getDbConnection();  // Obtenemos la conexión a la base de datos (objeto PDO).
    $stmt = $db->prepare($sqlCmd);  // Obtenemos el Statement de la sentencia SQL.
    $stmt->execute($sqlParams);  // Ejecutamos el Statment con los parámetros (solo username)
    $r = $stmt->fetchAll();  // Obtenemos un array de assoc array de los registros encontrados.

    // Si no se regresó ninguna coincidencia (consultando por el username) 
    // se regresa un false.
    if (!$r) return false;

    // Obtenemos el registro del usuario de los resultados de la consulta.
    // Si el usuario no está activo, regresamos false.
    $usuario = $r[0];
    if (!$usuario['activo']) return false;

    // Se obtiene el hash que representa el password junto con el salt
    $passwordMasSalt = $password . $usuario["password_salt"];
    $passwordHashed = strtoupper(hash("sha512", $passwordMasSalt));

    // Si el hash (con el salt) del password proporcionado es diferente al que está 
    // en la base de datos, se regresa un false.
    if ($usuario["password"] != $passwordHashed) return false;

    // Se regresa un assoc array con los datos el usuario.
    return [
        "id" => $usuario['id'] ,
        "username" => $usuario["username"],
        "email" => $usuario["email"],
        "nombre" => $usuario["nombre"],
        "apellidos" => $usuario["apellidos"],
        "foto_perfil" => $usuario["foto_perfil"]
    ];
}

// De los parámetros de username y password los validamos, obtendremos los datos
// del usuario si el login es correcto.
$loginCorrecto = autentificar($username, $password);

// Si no obtuvimos datos, regresamos al index
if (!$loginCorrecto) {
    $resObj["error"] = "Nombre de usuario o contraseña incorrectos.";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // termina la ejecución.
}

// Establecemos variables de sesión con los datos del usuario.
$_SESSION['Usuario_Id'] = $loginCorrecto['id'];
$_SESSION['Usuario_Username'] = $loginCorrecto['username'];
$_SESSION['Usuario_Email'] = $loginCorrecto['email'];
$_SESSION['Usuario_Nombre'] = $loginCorrecto['nombre'];
$_SESSION['Usuario_Apellidos'] = $loginCorrecto['apellidos'];
$_SESSION['Usuario_Foto_Perfil'] = $loginCorrecto['foto_perfil'];

// Regresamos el JSON con los datos del usuario.
$resObj["mensaje"] = "Inicio de sesión correcto.";
echo json_encode($resObj);

?>
