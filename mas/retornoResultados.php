<?php
// Configuración
$CantidadMostrar = 10;
$paginaActual = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

// Obtener filtros
$filtroCiudad = isset($_GET['ciudad']) ? trim($_GET['ciudad']) : '';
$filtroTipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$filtroPrecioMin = isset($_GET['minPrecio']) ? (float)$_GET['minPrecio'] : 0;
$filtroPrecioMax = isset($_GET['maxPrecio']) ? (float)$_GET['maxPrecio'] : PHP_FLOAT_MAX;

// Obtener el filtro de precio si está presente
$precioFiltro = isset($_GET['precio']) ? $_GET['precio'] : '';
$precioDesde = $precioHasta = '';
if ($precioFiltro) {
    $precioRango = explode(';', $precioFiltro);
    $precioDesde = isset($precioRango[0]) ? (float)str_replace([',', '$'], '', $precioRango[0]) : $filtroPrecioMin;
    $precioHasta = isset($precioRango[1]) ? (float)str_replace([',', '$'], '', $precioRango[1]) : $filtroPrecioMax;
}

// Logica para las busquedas

if ($filtroCiudad == "" && $filtroTipo != "")
{
    echo '<p>En <strong>todas</strong> las ciudades, hemos encontrado estos/as <strong>' . htmlspecialchars($filtroTipo) . '</strong>, con precios desde <strong>' . htmlspecialchars($precioDesde) . '</strong> hasta <strong>' . htmlspecialchars($precioHasta) . '</strong></p>';
}

else if ($filtroCiudad != "" && $filtroTipo == "")
{
    echo '<p>En la ciudad de <strong>' . htmlspecialchars($filtroCiudad) . '</strong>, hemos encontrado <strong>todos</strong> estos tipos, con precios desde <strong>' . htmlspecialchars($precioDesde) . '</strong> hasta <strong>' . htmlspecialchars($precioHasta) . '</strong></p>';
}

else if ($filtroCiudad != "" && $filtroTipo != "")
{
    echo '<p>En la ciudad de <strong>' . htmlspecialchars($filtroCiudad) . '</strong>, hemos encontrado estos/as <strong>' . htmlspecialchars($filtroTipo) . '</strong>, con precios desde <strong>' . htmlspecialchars($precioDesde) . '</strong> hasta <strong>' . htmlspecialchars($precioHasta) . '</strong></p>';
}

else if ($filtroCiudad == "" && $filtroTipo == "" && $precioDesde == 0 && $precioHasta == 100000)
{
    echo '<p>Mostrando <strong>todos</strong> los sitios</p>';
}

else
{
    echo '<p>En <strong>todas</strong> las ciudades y en <strong>todos</strong> los tipos, hemos encontrado estos precios desde <strong>' . htmlspecialchars($precioDesde) . '</strong> hasta <strong>' . htmlspecialchars($precioHasta) . '</strong></p>';
}

// Cargar los datos del JSON
$data = file_get_contents('data-1.json');
$data = json_decode($data, true);

// Filtrar los datos
if (is_array($data)) {
    $datosFiltrados = array_filter($data, function($item) use ($filtroCiudad, $filtroTipo, $precioDesde, $precioHasta) {
        // Asegurarse de que los valores de precio sean numéricos
        $precio = isset($item['Precio']) ? (float)str_replace([',', '$'], '', $item['Precio']) : 0;

        // Verificar filtros
        $ciudadMatch = empty($filtroCiudad) || stripos($item['Ciudad'], $filtroCiudad) !== false;
        $tipoMatch = empty($filtroTipo) || $item['Tipo'] === $filtroTipo;  // Cambio aquí para coincidencia exacta
        $precioDesdeMatch = $precio >= $precioDesde;
        $precioHastaMatch = $precio <= $precioHasta;

        return $ciudadMatch && $tipoMatch && $precioDesdeMatch && $precioHastaMatch;
    });

    // Número total de elementos
    $totalRegistros = count($datosFiltrados);

    // Paginación
    $totalPaginas = ceil($totalRegistros / $CantidadMostrar);
    $offset = ($paginaActual - 1) * $CantidadMostrar;
    $datosParaMostrar = array_slice($datosFiltrados, $offset, $CantidadMostrar);
    
    // Mostrar la tabla
    if (count($datosParaMostrar) > 0) {
        echo '<table border="1">';
        echo '<thead><tr>';
        
        // Encabezados de la tabla (asume que todos los datos tienen las mismas claves)
        foreach (array_keys($datosParaMostrar[0]) as $key) {
            echo '<th>' . htmlspecialchars($key) . '</th>';
        }
        echo '</tr></thead><tbody>';
        
        // Datos de la tabla
        foreach ($datosParaMostrar as $row) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
        
        // Mostrar la paginación
        echo '<ul class="paginacionhorizontal">';
        // Botón de página anterior
        $paginaAnterior = ($paginaActual > 1) ? $paginaActual - 1 : 1;
        echo '<li><a href="?pag=' . $paginaAnterior . '&ciudad=' . urlencode($filtroCiudad) . '&tipo=' . urlencode($filtroTipo) . '&precio=' . urlencode($precioFiltro) . '&minPrecio=' . $filtroPrecioMin . '&maxPrecio=' . $filtroPrecioMax . '">◀</a></li>';

        // Botones de página
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == $paginaActual) {
                echo '<li class="active"><a href="?pag=' . $i . '&ciudad=' . urlencode($filtroCiudad) . '&tipo=' . urlencode($filtroTipo) . '&precio=' . urlencode($precioFiltro) . '&minPrecio=' . $filtroPrecioMin . '&maxPrecio=' . $filtroPrecioMax . '">' . $i . '</a></li>';
            } else {
                echo '<li><a href="?pag=' . $i . '&ciudad=' . urlencode($filtroCiudad) . '&tipo=' . urlencode($filtroTipo) . '&precio=' . urlencode($precioFiltro) . '&minPrecio=' . $filtroPrecioMin . '&maxPrecio=' . $filtroPrecioMax . '">' . $i . '</a></li>';
            }
        }

        // Botón de página siguiente
        $paginaSiguiente = ($paginaActual < $totalPaginas) ? $paginaActual + 1 : $totalPaginas;
        echo '<li><a href="?pag=' . $paginaSiguiente . '&ciudad=' . urlencode($filtroCiudad) . '&tipo=' . urlencode($filtroTipo) . '&precio=' . urlencode($precioFiltro) . '&minPrecio=' . $filtroPrecioMin . '&maxPrecio=' . $filtroPrecioMax . '">▶</a></li>';
        echo '</ul>';
    } else {
        echo 'No se encontraron datos.';
    }
} else {
    echo 'Error al cargar los datos.';
}
?>
