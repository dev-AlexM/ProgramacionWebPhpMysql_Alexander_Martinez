<?php
// Captura el valor del tipo seleccionado desde la URL
$selectedTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Ruta al archivo JSON
$archivo_json = 'data-1.json';

// Verifica si el archivo JSON existe
if (!file_exists($archivo_json)) {
    echo '<option value="" disabled>Error al cargar tipos</option>';
    exit;
}

// Lee el contenido del archivo JSON
$json_data = file_get_contents($archivo_json);

// Decodifica el contenido JSON
$datos = json_decode($json_data, true);

// Verifica si la decodificación fue exitosa
if (json_last_error() !== JSON_ERROR_NONE) {
    echo '<option value="" disabled>Error al procesar datos</option>';
    exit;
}

// Array para almacenar los tipos de propiedades
$tipos = [];

// Extrae los tipos de propiedades y elimina duplicados
foreach ($datos as $propiedad) {
    if (isset($propiedad['Tipo'])) {
        $tipos[] = $propiedad['Tipo'];
    }
}

// Elimina duplicados usando array_unique
$tipos = array_unique($tipos);

// Ordena los tipos alfabéticamente
sort($tipos);

// Genera las opciones HTML
foreach ($tipos as $tipo) {
    // Marca la opción seleccionada
    $selected = ($tipo == $selectedTipo) ? ' selected' : '';
    echo "<option value=\"$tipo\"$selected>$tipo</option>";
}
?>
