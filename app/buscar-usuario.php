<?php

require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Es recomendable usar la función filter_input para obtener los valores recibidos
// dentro de la petición POST (también aplica para variables URL, lo que está en $_GET)
$buscarUsuario = trim(filter_input(INPUT_POST, "buscar-usuario"));

// Consulta para obtener el usuario por su username.
$sqlCmd = "SELECT * FROM usuarios WHERE username LIKE ? ORDER BY id DESC";
$sqlParams = ["%$buscarUsuario%"];  // Parámetros a enviar en la consulta.

// Ejecución de la sentencia SQL con la base de datos.
$db = getDbConnection();  // Obtenemos la conexión a la base de datos (objeto PDO).
$stmt = $db->prepare($sqlCmd);  // Obtenemos el Statement de la sentencia SQL.
$stmt->execute($sqlParams);  // Ejecutamos el Statment con los parámetros (solo username)
$r = $stmt->fetchAll();  // Obtenemos un array de assoc array de los registros encontrados.

?>
