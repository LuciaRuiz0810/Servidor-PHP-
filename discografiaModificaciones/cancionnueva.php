<?php
  session_start();

  $conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

  if ($_SESSION['autenticado'] != true || !isset($_SESSION['autenticado'])) {
    header('Location: login.php');
    exit;
  }
//Obtenemos el codigo del album
$album_ref = trim($_GET['codigo']);
$nombre_album = trim($_GET['nombre_album']);

//Mostramos el titulo del album en el que va a añadir la canción
echo "<header><h2>Estas añadiendo la canción al albúm: " .$nombre_album . "</h2></header>";

echo  '<form action="#" method="post">';
//Creamos el input y el botón para enviar la nueva canción
echo '<label type=text name=agregar>Agrega la nueva cancion </label>';
echo '<input type=text name=agregar>';
echo '<input type=submit name=enviar value=Enviar>';


try {
    if (isset($_POST['enviar'])) {
        //Si el titulo está vacio se indica
        if (empty($_POST['agregar'])) {
            throw new Exception('Debes introducir un nombre!');
        } else {

            //Obtenemos el titulo de la nueva cancion (name del input)
            $titulo_nuevo = trim($_POST['agregar']);
            //Consulta donde insertaremos el codigo del album y el título
            $insertar = $conexion->prepare("INSERT INTO cancion (titulo, album) VALUES (?, ?)");
            $resultado = $insertar->execute([$titulo_nuevo, $album_ref]);


            //Se informará de si se agrega o no correctamente
            if ($resultado) {
                  echo '<p style="color:green;">Canción agregada correctamente.</p>';
            } else {
                 echo '<p style="color:red;">ERROR: La canción no se ha podido agregar.</p>';
            }
        }
    }
    //Si ocurre una excepción se mostrará el error
} catch (Exception $e) {
    echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';
}
