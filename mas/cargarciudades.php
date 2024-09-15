<?php
// Captura el valor de la ciudad seleccionada desde la URL
$selectedCiudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : '';

// Ruta al archivo JSON
$archivo_json = 'data-1.json';

// Verifica si el archivo JSON existe
if (!file_exists($archivo_json)) {
    echo '<option value="" disabled>Error al cargar ciudades</option>';
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

// Array para almacenar las ciudades
$ciudades = [];

// Extrae las ciudades y elimina duplicados
foreach ($datos as $propiedad) {
    if (isset($propiedad['Ciudad'])) {
        $ciudades[] = $propiedad['Ciudad'];
    }
}

// Elimina duplicados usando array_unique
$ciudades = array_unique($ciudades);

// Ordena las ciudades alfabéticamente
sort($ciudades);

// Genera las opciones HTML
foreach ($ciudades as $ciudad) {
    // Marca la opción seleccionada
    $selected = ($ciudad == $selectedCiudad) ? ' selected' : '';
    echo "<option value=\"$ciudad\"$selected>$ciudad</option>";
}
?>
