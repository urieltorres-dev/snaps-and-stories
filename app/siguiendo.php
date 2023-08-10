<?php

require_once 'helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Se obtiene el usuario visitado.
$username = filter_input(INPUT_GET, 'username');

// Se obtiene el id del uauario visitado.
$sqlCmd = "SELECT * FROM usuarios WHERE username = ?"; // Sentencia SQL a ejecutar.
$sqlParams = [$username];  // Parámetros a enviar en la consulta.
$db = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams);  //  Ejecutamos la consulta.
$infoUsuarioVisitado = $stmt->fetch();  // Obtenemos el resultado de la consulta.

// Se obtiene el registro de seguimiento
$sqlCmd2 = "SELECT * FROM seguidores WHERE usuario_siguiendo_id = ? AND usuario_seguidor_id = ?"; // Sentencia SQL a ejecutar.
$sqlParams2 = [$infoUsuarioVisitado['id'], $USUARIO_ID];  // Parámetros a enviar en la consulta.
$db2 = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt2 = $db2->prepare($sqlCmd2);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt2->execute($sqlParams2);  //  Ejecutamos la consulta.
$seguimiento = $stmt2->fetch();  // Obtenemos el resultado de la consulta.

// Si se esta siguiendo el usuario, se muestra el botón "Dejar de seguir", de lo contrario, se muestra el botón "Seguir".
if ($seguimiento) {
    $btnSeguir = "Dejar de seguir";
    if ($seguimiento['eliminado'] == 1) {
        $btnSeguir = "Seguir";
    }
} else {
    $btnSeguir = "Seguir";
}

?>