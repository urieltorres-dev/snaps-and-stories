<?php

require_once '../helpers/config.php';
require_once APP_PATH . 'helpers/db.php';
require_once APP_PATH . 'helpers/sesion.php';
require_once APP_PATH . 'helpers/sesion-requerida.php';

// Indicamos que el tipo de respuesta será un JSON, pues esta acción debe llamarse por AJAX.
header("Content-Type: application/json");

$now = new DateTime();  // Objeto DateTime que representa la fecha-hora actual.
$resObj = ["error" => NULL, "mensaje" => NULL];  // Assoc array con los datos que regresaremos.

// Valida que se haya recibido el archivo en la petición HTTP Post.
if (empty($_FILES["foto"]["name"])) {   // Si no se envió el archivo en la petición.
    $resObj["error"] = "No se envió el archivo de la foto a guardar.";  // Error a regresar.
    echo json_encode($resObj);  // regresamos la respuesta en JSON.
    exit;  // termina la ejecución.
}

// Se valida que el archivo sea de tipo imagen según la extensión de este.
$nombreArchivo = $_FILES["foto"]["name"];  // Se obtiene el nombre original del archivo.
$extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));  // Obtenemos la extensión del archivo.
if (!in_array($extension, $EXT_ARCHIVOS_FOTOS)) {  // Si la extensión no está en el array de extensiónes $EXT_ARCHIVOS_FOTOS (definido en config.php)
    $resObj["error"] = "La extensión $extension no es válida para archivos de fotos.";  // Error a regresar
    echo json_encode($resObj);   // regresamos la respuesta en JSON.
    exit;   // termina la ejecución.
}

// Se obtiene la descripcción del archivo que se subió.
$descripcion = filter_input(INPUT_POST, "descripcion");
// Validamos que la descripcion no tenga una longitud mayor a 1024 caracteres.
if (strlen($descripcion) > 1024) {
    $resObj["error"] = "La descripción no puede tener más de 1024 caracteres.";  // Error a regresar.
    echo json_encode($resObj);  // regresamos la respuesta en JSON.
    exit;  // termina la ejecución.
}

$now = new DateTime();  // Fecha hora actual.

$tamaño = $_FILES["foto"]["size"];  // Obtenemos el tamaño del archivo que se envió.
$secureId = strtoupper(bin2Hex(random_bytes(32)));  // Se genera el secureId a partir de bytes random.
$rutaArchivoTemp = $_FILES["foto"]["tmp_name"];  // ruta temporal del archivo que se subió.

// Ruta donde guardaremos el archivo. El archivo no se guardará con el nombre origina, puesto
// que este puede reemplazar uno ya existente, por eso lo guardamos con el nombre generado como
// secureId. También lo guardamos sin extensión, pero sigue teniendo el contenido de la imagen y
// también lo podemos seguir leyendo programáticamente.
$rutaArchivoAGuardar = DIR_UPLOADS . $secureId; 

// Guardamos el archivo desde la locación temporal hasta la ruta final donde quedará.
move_uploaded_file($rutaArchivoTemp, $rutaArchivoAGuardar);

// Se obtiene el objeto PDO que es con el que vamos a interactuar con DB.
$db = getDbConnection();

// La sentencia SQL con la que vamos a insertar los datos.
$sqlCmd =   // Sentencia SQL para el insert del registro del archivo en table fotos.
        "INSERT INTO fotos " .
        "    (secure_id, usuario_subio_id, nombre_archivo, tamaño, descripcion, " .
        "     fecha_subido, eliminado)" . 
        "    VALUES (?, ?, ?, ?, ?, ?, ?)";   // <-- Parámetros de la sentencia.

$params = [     // Especificación de los parémtros de la sentencia SQL del Insert.
    $secureId,    // secure_id -> el secureId del archivo, que también es el nombre del archivo como se guardó en la carpeta.
    $USUARIO_ID,  // usuario_subio_id -> identificador del usuario actual (de la sesión), que está especificado en sesion.php
    $nombreArchivo,  // nombre_archivo -> nombre original del archivo.
    $tamaño,        // tamaño -> tamaño del archivo en bytes.
    ($descripcion ? trim($descripcion) : NULL),  // descripcion -> descripción del archivo, si se especificó, guardamos el trim (quita espacios en blanco al principio y al final), de otra forma guardamos null.
    $now->format("Y-m-d H:i:s"),  // fecha_subido -> la fecha hora actual, lo enviamos como string en formato 0000-00-00 00:00:00
    0     //eliminado -> eliminado 0 porque no se ha eliminado, apenas se insertó.
];

// Elecución del insert del registro en la table fotos.
$stmt = $db->prepare($sqlCmd);  // Obtenemos el objeto Statement que representa la ejecución de la senttencia SQL.
$stmt->execute($params);   // Realizamos la ejecución especificando los parámetros.
$fotoId = (int)$db->lastInsertId();  // Obtenemos el id generado por la base de datos.

if($fotoId == NULL){
    $resObj["error"] = "Se produjo un error al guardar el registro en la base de datos.";
}else{
    // Mensaje que queremos regresar.
    $resObj["mensaje"] = "Se guardó el archivo correctamente.";
}

// Regresamos la respuesta en JSON.
echo json_encode($resObj);

?>
