<?php

// Archivos de código necesarios para la ejecución de esta página.
require_once "../helpers/config.php";
require_once APP_PATH . "helpers/db.php";
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$now = new DateTime();  // Fecha hora actual.

// Obtenemos el id del usuario que dio like.
$id_usuario = $USUARIO_ID;

// Obtenemos el id de la foto que recibió el like.
$id_foto = filter_input(INPUT_POST, "fotoId");

// Realizamos una consulta para ver si el like ya existe.
$consulta = "SELECT * FROM fotos_likes WHERE usuario_dio_like_id = ? AND foto_id = ?";
$params = [$id_usuario, $id_foto];
$db = getDbConnection();
$stmt = $db->prepare($consulta);
$stmt->execute($params);
$r = $stmt->fetchAll();

// Si el like ya existe, lo eliminamos.
if (count($r) > 0) {
    if (count($r) > 0 && $r[0]["eliminado"] == 1) { // Si el like ya existe y esta eliminado, lo agregamos.
        $consulta = "UPDATE fotos_likes SET eliminado = 0 WHERE usuario_dio_like_id = ? AND foto_id = ?";
        $params = [$id_usuario, $id_foto];
        $db = getDbConnection();
        $stmt = $db->prepare($consulta);
        $stmt->execute($params);
        $r = $stmt->fetchAll();
        $respuesta = ["status" => "ok", "accion" => "agregar"];
    } else { // Si el like ya existe y no esta eliminado, lo eliminamos.
        $consulta = "UPDATE fotos_likes SET eliminado = 1 WHERE usuario_dio_like_id = ? AND foto_id = ?";
        $params = [$id_usuario, $id_foto];
        $db = getDbConnection();
        $stmt = $db->prepare($consulta);
        $stmt->execute($params);
        $r = $stmt->fetchAll();
        $respuesta = ["status" => "ok", "accion" => "eliminar"];
    }
} else {  // Si el like no existe, lo agregamos.
    $consulta = "INSERT INTO fotos_likes (foto_id, usuario_dio_like_id, fecha_hora, eliminado) VALUES (?, ?, ?, ?)";
    $params = [$id_foto, $id_usuario, $now->format("Y-m-d H:i:s"), 0];
    $db = getDbConnection();
    $stmt = $db->prepare($consulta);
    $stmt->execute($params);
    $r = $stmt->fetchAll();
    $respuesta = ["status" => "ok", "accion" => "agregar"];
}

// Obtenemos el número de likes de la foto.
$consulta = "SELECT COUNT(*) AS likes FROM fotos_likes WHERE foto_id = ? AND eliminado = 0";
$params = [$id_foto];
$db = getDbConnection();
$stmt = $db->prepare($consulta);
$stmt->execute($params);
$r = $stmt->fetch();
$respuesta["likes"] = $r["likes"];

// Obtenemos si el usuario logueado le dio like a la foto.
$consulta = "SELECT * FROM fotos_likes WHERE foto_id = ? AND usuario_dio_like_id = ? AND eliminado = 0";
$params = [$id_foto, $id_usuario];
$db = getDbConnection();
$stmt = $db->prepare($consulta);
$stmt->execute($params);
$r = $stmt->fetch();
$respuesta["like"] = $r ? true : false;

echo json_encode($respuesta);

?>
