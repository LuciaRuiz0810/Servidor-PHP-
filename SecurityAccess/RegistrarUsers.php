<?php
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

//Si el usuario envia el formulario:
if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //Recogemos los datos de los inputs con el "name" de cada uno
    $pass = $_POST["contraseña_usuario"];
    $user = $_POST["nombre_usuario"];


    try {
        //Hashea la contraseña introducida
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        //consulta para insertar en la tabla el usuario y la contraseña hasheada
        $consulta = $conexion->prepare('INSERT INTO tabla_usuarios (usuario, password) VALUES (?, ?)');
        $consulta->execute([$user, $hash]);
        if($consulta){
            echo '<p style= color:green>Usuario registrado!</p>';
        }else{
            throw new Exception('No se ha podido registrar el usuario!');
        }
    } catch (Exception $e) {
        echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';
    }
}

?>
<!--Registro de usuarios HMTL-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuarios</title>
</head>

<body>
    <h3>Registrar Usuarios</h3>
    <form action="#" method="post">
        <label for="user">Usuario:</label>
        <input type="text" name="nombre_usuario">
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña_usuario">
        <br> <br>
        <input type="submit" value="Registrarse">
    </form>
    <br> <br>
    <a href="login.php">Ir a Login</a>
</body>

</html>