<?php
session_start(); //El inicio de sesión debe estar en todos los archivos

$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

//Si ya está autenticado, le mandará directamente al login
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['enviar'])) {
    $user = $_POST['usuario'];
    $pass = $_POST['contraseña'];

    try {
        //Recogemos la contraseña del usuario introducido en la base de datos
        $consulta_busqueda = $conexion->prepare('SELECT password, id,usuario from tabla_usuarios where usuario= ?');
        $consulta_busqueda->execute([$user]);
        $resultado =  $consulta_busqueda->fetch(PDO::FETCH_ASSOC);

        //Comprobamos que coincidan la contraseña introducida con la obtenida
        if (password_verify($pass, $resultado['password'])) {
            /*Si el usuario entra correctamente, se indica que se ha autenticado, de esta manera 
            mientras la sesión esté activa, no deberá volver a pasar por el login*/
            $_SESSION['autenticado'] = true;
            $_SESSION['Id_user'] = $resultado['id'];
            $_SESSION['username'] = $resultado['usuario'];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['autenticado'] = false;
            throw new PDOException('Los datos son incorrectos!');
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
    <title>Login Discografía</title>
</head>

<body>
    <form action="#" method="post">

        <label for="usuario">Introduce tu usuario:</label>
        <input type="text" name="usuario">
        <br><br>
        <label for="contraseña">Introduce tu Contraseña:</label>
        <input type="password" name="contraseña">
        <br><br>
        <button type="submit" name="enviar">Enviar</button>

    </form>
    <p>Ir a <a href="Registro.php">Registrarse</a></p>


</body>

</html>