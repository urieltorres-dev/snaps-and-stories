<?php 

require_once APP_PATH . "helpers/db.php";
require_once APP_PATH . "helpers/sesion.php";
require_once APP_PATH . "helpers/sesion-requerida.php";

// Sentencia SQL para obtener las fotos publicadas por el usuario y las fotos publicadas por los usuarios que sigue
$sqlCmd = "SELECT f.*
        FROM 
		fotos_v f
        LEFT OUTER JOIN seguidores s
			ON f.usuario_subio_id = s.usuario_siguiendo_id
	WHERE ((s.usuario_seguidor_id = ? AND s.eliminado = ?) OR f.usuario_subio_id = ?) AND f.eliminado = ?
    ORDER BY f.fecha_subido DESC";
$sqlParams = [
    $USUARIO_ID,
    0,
    $USUARIO_ID,
    0,
];
$db = getDbConnection();  // Se obtiene el objeto PDO para el acceso a DB.
$stmt = $db->prepare($sqlCmd); // Preparamos la sentencia SQL a ejecutar y obtenemos el Statement.
$stmt->execute($sqlParams); //  Ejecutamos la consulta.
$fotos = $stmt->fetchAll(); // Obtenemos el resultado de la consulta.

?>
