 <?php
  session_start();

  $conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

  if ($_SESSION['autenticado'] != true || !isset($_SESSION['autenticado'])) {
    header('Location: login.php');
    exit;
  }

  //Recoge el codigo del archivo indes.php
  $codigo = trim($_GET['codigo']);
  
  //Seleccionamos los titulos de las canciones donde el codigo sea el mismo que el obtenido de index.php
  $consulta_cancion =  $conexion->prepare("SELECT titulo from cancion where album= ?");
  //Ejecutamos la consulta
  $consulta_cancion->execute([$codigo]);

  //Seleccionamos titulo el del album con el codigo que corresponda
  $consulta =  $conexion->prepare("SELECT titulo from album where codigo= ?");
  $consulta->execute([$codigo]);
  //Recogemos datos
  $fila_album = $consulta->fetch(PDO::FETCH_ASSOC);
  //Obtenemos el titulo para luego mostrarlo cada vez que querramos añadir una canción
  $nombre_album = $fila_album['titulo'];

  echo '<h2>Lista Canciones</h2>';
  echo '<ul>';
  //Recorremos la consulta por filas y mostramos las canciones en una lista
  while ($canciones = $consulta_cancion->fetch(PDO::FETCH_ASSOC)) {
    echo '<li>' . $canciones['titulo'] . '</li>';
  }
  echo '</ul>';

  //Enlace para agregar la nueva canción que envía el codigo y el titulo del albúm a cancionnueva
  echo "<p><a href='cancionnueva.php?codigo=$codigo&nombre_album=$nombre_album'>Agregar una canción nueva</a></p>";


  ?>
 
