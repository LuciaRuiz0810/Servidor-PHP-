<?php


//Crea la conexión con la base de datos a través de PDO
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

//Seleccionamos el titulo y el codigo del album
$consulta = $conexion -> query('SELECT titulo, codigo FROM album');

echo '<h2>Lista Discos</h2>';

//Mostrar el mensaje que se haya obtenido
if(isset($_GET['msg'])){
  $msg = $_GET['msg'];
   echo "<div><p style=  color:green>" . $msg . "</p></div>";
}

if(isset($_GET['msgE'])){
  $msg = $_GET['msgE'];
   echo "<div><p style=  color:red>" . $msg . "</p></div>";
}

echo '<form action=disco.php method=post';

echo '<ul>';

//Recorremos las filas de la consulta y las mostramos en una lista
while ($fila_album = $consulta-> fetch(PDO::FETCH_ASSOC)) {
    //Guardamos el codigo de cada album
    $codigo = $fila_album['codigo'];
    echo  "<li>
        <a href='disco.php?codigo=$codigo'>{$fila_album['titulo']}</a>
        <a href='borrardisco.php?codigo=$codigo'> - Borrar disco</a>
         
      </li>";
}
echo '<br>';
//Enlaces para añadir o buscar canción
echo "<a href='albumnuevo.php?codigo=$codigo'> - Añadir albúm</a>";
echo '<br>';
echo "<a href='canciones.php'> - Buscar canción</a>";



?>
