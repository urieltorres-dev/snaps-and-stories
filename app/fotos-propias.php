<?php

require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';


$sqlCmd = "SELECT * FROM fotos WHERE usuario_subio_id = ? AND eliminado = ?"; // Sentencia SQL a ejecutar.
$sqlParams = [$infoUsuario["id"], 0];  // Parámetros a enviar en la consulta.7
$db = getDbConnection();   // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd);  // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams);  //  Ejecutamos la consulta.
$fotos = $stmt->fetchAll();  // Obtenemos el resultado de la consulta.

?>
