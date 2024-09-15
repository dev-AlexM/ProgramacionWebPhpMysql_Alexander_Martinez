<?php
// Nombre del archivo JSON
$archivo_json = 'data-1.json';

// Verifica si el archivo JSON existe
if (!file_exists($archivo_json)) {
    echo json_encode(['error' => 'El archivo JSON no existe']);
    exit;
}

// Lee el contenido del archivo JSON
$contenido_json = file_get_contents($archivo_json);

// Envía el contenido como respuesta JSON
header('Content-Type: application/json');
echo $contenido_json;
?>
