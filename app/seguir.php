<?php

require_once '../helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

$seguidor = filter_input(INPUT_POST, 'usuarioVisitante');
$seguido = filter_input(INPUT_POST, 'usuarioVisitado');

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");
$resObj = ["error" => NULL, "mensaje" => NULL];  // Assoc array con los datos que regresaremos.

// Validamos que los datos recibidos no estén vacíos.
if (empty($seguidor) || empty($seguido)) {
    $resObj["error"] = "No se recibieron los datos necesarios."; // Error a regresar.
    echo json_encode($resObj);  // regresamos la respuesta en JSON.
    exit;  // termina la ejecución.
}

// Validamos que el usuario visitado y el usuario visitante sean diferentes.
if ($seguidor == $seguido) {
    $resObj["error"] = "No se puede seguir a uno mismo.";  // Error a regresar.
    echo json_encode($resObj);  // regresamos la respuesta en JSON.
    exit;  // termina la ejecución.
}

// Comprobar si el usuario ya sigue al usuario visitado
$sqlCmd = "SELECT * FROM seguidores WHERE usuario_siguiendo_id = ? AND usuario_seguidor_id = ?"; // Sentencia SQL a ejecutar.
$sqlParams = [$seguido, $seguidor];  // Parámetros a enviar en la consulta.
$db = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams);  //  Ejecutamos la consulta.
$seguimiento = $stmt->fetch();  // Obtenemos el resultado de la consulta.

$r = NULL;  // Variable para almacenar el resultado de la consulta.

if ($seguimiento) { // El usuario ya sigue al usuario visitado.
    // Si existe el seguimiento, y esta activo se desactiva
    if ($seguimiento['eliminado'] == 0){
        $sqlCmd2 = "UPDATE seguidores SET eliminado = 1 WHERE usuario_siguiendo_id = ? AND usuario_seguidor_id = ?"; // Sentencia SQL a ejecutar.
        $sqlParams2 = [$seguido, $seguidor];  // Parámetros a enviar en la consulta.
        $db2 = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
        $stmt2 = $db2->prepare($sqlCmd2);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
        $r = $stmt2->execute($sqlParams2);  //  Ejecutamos la consulta.

        // Si se ha podido eliminar el seguimiento, se muestra un mensaje de éxito.
        if ($r) {
            $resObj["mensaje"] = "Se ha eliminado el seguimiento correctamente.";  // Mensaje a regresar.
            echo json_encode($resObj);  // regresamos la respuesta en JSON.
            exit;  // termina la ejecución.
            
        }

        // Si no se ha podido eliminar el seguimiento, se muestra un mensaje de error.
        $resObj["error"] = "No se pudo eliminar el seguimiento.";  // Error a regresar.
        echo json_encode($resObj);  // regresamos la respuesta en JSON.
        exit;  // termina la ejecución.
    }

    // Si existe el seguimiento, pero está eliminado, se actualiza eliminado a 0
    if ($seguimiento['eliminado'] == 1) {
        $sqlCmd1 = "UPDATE seguidores SET eliminado = 0 WHERE usuario_siguiendo_id = ? AND usuario_seguidor_id = ?"; // Sentencia SQL a ejecutar.
        $sqlParams1 = [$seguido, $seguidor];  // Parámetros a enviar en la consulta.
        $db1 = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
        $stmt1 = $db1->prepare($sqlCmd1);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
        $r = $stmt1->execute($sqlParams1);  //  Ejecutamos la consulta.

        // Si se ha podido actualizar el seguimiento, se muestra un mensaje de éxito.
        if ($r) {
            $resObj["mensaje"] = "Se ha actualizado el seguimiento correctamente.";  // Mensaje a regresar.
            echo json_encode($resObj);  // regresamos la respuesta en JSON.
            exit;  // termina la ejecución.
        }

        // Si no se ha podido actualizar el seguimiento, se muestra un mensaje de error.
        $resObj["error"] = "No se pudo actualizar el seguimiento.";  // Error a regresar.
        echo json_encode($resObj);  // regresamos la respuesta en JSON.
        exit;  // termina la ejecución.
    }

} else { // El usuario no sigue al usuario visitado.
    $now = new DateTime(); // Fecha y hora actual.
    $sqlCmd0 = "INSERT INTO seguidores (usuario_siguiendo_id, usuario_seguidor_id, fecha_hora) VALUES (?, ?, ?)"; // Sentencia SQL a ejecutar.
    $sqlParams0 = [$seguido, $seguidor, $now->format('Y-m-d H:i:s')];  // Parámetros a enviar en la consulta.
    $db0 = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
    $stmt0 = $db0->prepare($sqlCmd0);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
    $r = $stmt0->execute($sqlParams0);  //  Ejecutamos la consulta.

    // Si se ha podido crear el seguimiento, se muestra un mensaje de éxito.
    if ($r) {
        $resObj["mensaje"] = "Se pudo seguir al usuario correctamente.";  // Mensaje a regresar.
        echo json_encode($resObj);  // regresamos la respuesta en JSON.
        exit;  // termina la ejecución.
        
    }

    // Si no se ha podido crear el seguimiento, se muestra un mensaje de error.
    $resObj["error"] = "No se pudo seguir al usuario.";  // Error a regresar.
    echo json_encode($resObj);  // regresamos la respuesta en JSON.
    exit;  // termina la ejecución.
}

?>
