<?php
// Verificar si es la primera carga (sin parámetros en la URL)
$esPrimeraCarga = empty($_GET);

if ($esPrimeraCarga) {
    echo '<p>¡Bienvenido! Puedes mostrar todos los sitios o buscar uno, escoge el que sea ideal para ti</p>';
}
?>