<?php

// Archivos de código necesarios para la ejecución de esta página.
require_once "../helpers/config.php";
require_once APP_PATH . "helpers/db.php";
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$now = new DateTime();  // Fecha hora actual.
$resObj = ["error" => NULL, "username" => $USUARIO_USERNAME]; // Assoc array de los datos que regresaremos somo JSON.

// Obtenemos el parámetro "secureId" enviado dentro de la petición HTTP POST.
$secureId = filter_input(INPUT_POST, "secureId");
if (!$secureId) {   // Si no se envió el parémtro, regresamos un error.
    $resObj["error"] = "Parámetro [secureId] no especificado.";
    echo json_encode($resObj);
    exit;
}

// Realizamos una consulta para obtener el registro de la foto existente según el secureId recibido como parémtro.
$sqlCmd = "SELECT * FROM fotos WHERE secure_id = ?";
$db = getDbConnection();   // Obtejemos el objeto PDO para realizar las operaciones a base de datos.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejcutar y con esto obtenemos el objeto Statement.
$stmt->execute([$secureId]);  // Ejecutamos la consulta con los parémtros especificados, que es el secureId.
$fotoRegistroExistente = $stmt->fetch();  // Obtenemos el primer registro.

// Validamos que exista el registro de la foto según su secureId.
if (!$fotoRegistroExistente) {   // Si no existe le registro.
    $resObj["error"] = "No se encontró foto con secureId $secureId";  // Mensaje de error.
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // Finalizamos la ejecución.
}

// También podemos validar de que solo el usuario que subió la foto pueda eliminar esta foto,
// que es una práctica muy común en las aplicaciones. A este tipo de restricciones se les 
// llama "reglas de negocio". Entonces para validar que el usuario que subió la foto sea el que
// pueda eliminarla, se la variable de sesión donde se tiene el id del usuario lo comparamos
// con el id del usuario del registro de la foto en el campo de usuario_subio_id que es donde
// guardamos quién fue el usuario que la subió.
if ($fotoRegistroExistente["usuario_subio_id"] != $USUARIO_ID)  {
    $resObj["error"] =                     // Mensaje de error.
            "No puede borrar una foto que no haya subido su usuario. " .
            "La foto es del usuario " . $fotoRegistroExistente["usuario_subio_username"];
    echo json_encode($resObj);   // Regresamos el JSON
    exit;   // Finalizamos la ejecución.
}

// Como estamos usando un borrado lógico, entonces lo que hacemos es modificar el campo de
// eliminado de la table fotos.
$fotoId = $fotoRegistroExistente["id"];  // identificador del registro a modificar.
$stmt = $db->prepare("UPDATE fotos SET eliminado = 1 WHERE id = ?");  // SQL con el UPDATE a ejecutar.
$stmt->execute([$fotoId]);  // Ejecucion del Statement SQL con los parámetros especificados.

if ($secureId == $USUARIO_FOTO_PERFIL){
    $sql = "UPDATE usuarios SET foto_perfil = ?";
    $db2 = getDbConnection();
    $stmt2 = $db2->prepare($sql);
    $stmt2->execute([NULL]);
    $_SESSION['Usuario_Foto_Perfil'] = NULL;
}

// Regresamos un JSON con la respuesta.
echo json_encode($resObj);

?>
