<?php
session_start();
//Crea la conexión con la base de datos a través de PDO
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

//Si no está autenticado o la sesión ha caducado, le mandará al login 
if($_SESSION['autenticado'] != true || !isset($_SESSION['autenticado'])){
       header('Location: login.php');
   exit;
}


//Seleccionamos el titulo y el codigo del album
$consulta = $conexion -> query('SELECT titulo, codigo FROM album');

$user_nombre =$_SESSION['username'];
$user_id = $_SESSION['Id_user'];
$ruta = "img/users/{$user_nombre}";

echo "<div style=text-align:left><img src='$ruta/{$user_id}Small.png' alt='imgPerfil'" . '<br><h4>Bienvenid@! <span>' . $user_nombre .'</strong></h4></div>';
echo "<a href='perfil.php'>Ver Perfil</a>";

//Mostrar el mensaje que se haya obtenido
if(isset($_GET['msg'])){
  $msg = $_GET['msg'];
   echo "<div><p style=  color:green>" . $msg . "</p></div>";
}

if(isset($_GET['msgE'])){
  $msg = $_GET['msgE'];
   echo "<div><p style=  color:red>" . $msg . "</p></div>";
}

echo '<h2>Lista de discos</h2>';
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
echo '<br>';
echo "<a href='logout.php'>Salir de la sesión</a>";
echo '<br> </form>';



?>
