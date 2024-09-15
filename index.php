<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/customColors.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/index.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/estiloPaginacion.css" media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/estiloPersonalizado.css" media="screen,projection"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Trabajo Final Buscador - Por: Alexander Javier Martinez Gomez</title>
  <link rel="icon" href="img/lupa.ico" type="image/x-icon">
  <script>
    function mostrarDatos() {
        // Construir la URL para la solicitud GET
        var url = 'index.php?ciudad=&tipo=&precio=0%3B100000&minPrecio=0&maxPrecio=100000';
        
        // Cambiar la URL en la barra de direcciones
        window.location.href = url;
    }
  </script>
</head>

<body>
  <video src="img/video.mp4" id="vidFondo"></video>

  <div class="contenedor">
    <div class="card rowTitulo tituloPrincipal">
      <h4>💼 Bienes Raices, ¿Qué te gustaría comprar?<br>¡Tenemos los mejores sitios para tí! 🗺️</h4>
    </div>
    <div class="colFiltros">
      <form action="index.php" method="get" id="formulario">
        <div class="filtrosContenido">
          <div class="tituloFiltros">
            <h5>Realizar una búsqueda personalizada</h5>
          </div>
          <div class="filtroCiudad input-field">
            <label for="selectCiudad">🗽 Ciudad:</label><br><br>
            <select name="ciudad" id="selectCiudad" class="browser-default">
              <option value="">Elige una ciudad</option>
              <?php include 'mas/cargarciudades.php'; ?>
            </select>
          </div>
          <div class="filtroTipo input-field">
            <label for="selectTipo">🏠 Tipo:</label><br><br>
            <select name="tipo" id="selectTipo" class="browser-default">
              <option value="">Elige un tipo</option>
              <?php include 'mas/cargartipos.php'; ?>
            </select>
          </div>
          <div class="filtroPrecio">
            <label for="rangoPrecio">🤑 Precio (min-max):</label>
            <input type="text" id="rangoPrecio" name="precio" placeholder="0-100000" value="<?php echo htmlspecialchars($_GET['precio'] ?? ''); ?>" readonly />
            <input type="hidden" id="minPrecio" name="minPrecio" value="<?php echo htmlspecialchars($_GET['minPrecio'] ?? '0'); ?>" />
            <input type="hidden" id="maxPrecio" name="maxPrecio" value="<?php echo htmlspecialchars($_GET['maxPrecio'] ?? '100000'); ?>" />
          </div>
          <div class="botonField">
            <input type="submit" class="btn white" value="Buscar" id="submitButton">
          </div>

          <!-- Contenedor del GIF -->

          <div style="width:100%;height:0;padding-bottom:86%;position:relative;">
            <iframe src="https://giphy.com/embed/k4pFC1XQVyCHdglECD" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/RevistaTuCasaNueva-tcn-tucasanueva-sevende-k4pFC1XQVyCHdglECD">via GIPHY</a></p>
          </div>
      </form>
    </div>

    <div class="colContenido">
      <div class="tituloContenido card">
        <h6 class="nombre">Trabajo Final Buscador 👨‍💻 Por: Alexander Javier Martinez Gomez</h6>
        <div class="divider"></div>
        <!-- Botón para mostrar todos los datos -->
        <button type="button" class="btn-flat waves-effect" onclick="mostrarDatos()" id="toggleButton">
          ✨ Mostrar Todos ✨
        </button>
        <!-- Mostrar resultados dependiendo de la acción -->
        <div id="datos">
          <?php 
            // Mostrar resultados filtrados si hay parámetros de búsqueda
            if (!empty($_GET)) {
              include 'mas/retornoResultados.php';
            } else {
              include 'mas/bienvenido.php'; 
            }          
          ?>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="js/jquery-3.0.0.js"></script>
  <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>
</html>
