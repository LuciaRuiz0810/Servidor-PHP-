<?php
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

if (isset($_POST['enviar'])) {
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    try {

        //Hashea la contraseña
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $consulta = $conexion->prepare('INSERT INTO tabla_usuarios (usuario, password)  VALUES (?,?)');
        $consulta->execute([$user, $hash]);

        if ($consulta) {
            echo '<p style="color: green;">Usuario registrado correctamente!</p>';

        } else {

            throw new Exception('No se ha podido registrar el usuario');
        }
    } catch (PDOException $e) {
        echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios en Discografía</title>
</head>

<body>
    <h2>Registrar nuevo usuario</h2>
    <form action="#" method="post">

        <label for="usuario">Nombre Usuario:</label>
        <input type="text" name="user" id="usuario">
        <br> <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="pass" id="contraseña">
        <br><br>
        <button type="submit" name="enviar">Enviar</button>
    </form>
    <p>Ir a <a href="login.php">Login</a></p>


</body>

</html>