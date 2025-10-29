<?php
  session_start();

  $conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

  if ($_SESSION['autenticado'] != true || !isset($_SESSION['autenticado'])) {
    header('Location: login.php');
    exit;
  }

echo  '<form action="#" method="post">';
//Formulario con todas las opciones
echo '<h2>Agrega el nuevo albúm</h2>';
echo '<label type=text name=agregar>Titulo</label>';
echo '<input type=text name=titulo>';
echo '<br><br>';
echo '<label type=text name=agregar>Discografía</label>';
echo '<input type=text name=discografía>';
echo '<br><br>';
echo '<label type=text name=agregar>Formato</label>';
echo '<input type=text name=formato>';
echo '<br><br>';
echo '<label type=text name=agregar>Fecha lanzamiento</label>';
echo '<input type=date name=fecha>';
echo '<br><br>';
echo '<label type=text name=agregar>Compra</label>';
echo '<input type=date name=compra>';
echo '<br><br>';
echo '<label type=text name=agregar>Precio</label>';
echo '<input type=text name=precio>';
echo '<br><br>';

//Botón para enviar
echo '<input type=submit name=enviar value=Enviar>';


try {
    if (isset($_POST['enviar'])) {
        //Si alguno de los campos está vacio genera una excepción
        if (empty($_POST['titulo']) || empty($_POST['discografía']) || empty($_POST['formato']) || empty($_POST['fecha']) || empty($_POST['compra']) || empty($_POST['precio'])) {
            throw new Exception('Debes introducir todos los campos!');
        } else {
            //Seleccionamos el código max y le sumamos 1 para asignarselo al nuevo
            $consulta_codigo = $conexion->query('SELECT MAX(codigo) from album');
            $cantidad = $consulta_codigo->fetchColumn();
            $codigo = $cantidad+1;
            
            //Obtenemos el contenido de todos los campos
            $titulo_nuevo = trim($_POST['titulo']);
            $discografia =  trim($_POST['discografía']);
            $Formato =  trim($_POST['formato']);
            $fecha =  trim($_POST['fecha']);
            $compra =  trim($_POST['compra']);
            $precio =  trim($_POST['precio']);

            //Insertamos en el album los contenidos de todos los campos
            $insertar = $conexion->prepare("INSERT INTO album (codigo, titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio) VALUES (?, ?, ?, ? ,?,?, ?)");
            $resultado = $insertar->execute([$codigo, $titulo_nuevo, $discografia, $Formato, $fecha, $compra,  $precio]);


            //Se informará de si se agrega o no correctamente
            if ($resultado) {
                //Mostrará la página index con el mensaje correspondiente
                header('Location: http://discografia.local/index.php?msg=Disco añadido correctamente');

            } else {
                //Si falla el mensaje se mostrará en albumnuevo.php
                echo '<p style: color=red>El album no se ha podido añadir correctamente!</p>';
            }
        }
    }
    //Si algo falla saltará el error
} catch (Exception $e) {
        echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';

}
