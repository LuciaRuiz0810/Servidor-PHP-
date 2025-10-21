<?php
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Recogemos los datos de los inputs con el "name" de cada uno
    $pass = $_POST["contraseña_usuario"];
    $user = $_POST["nombre_usuario"];

    try {
        //Consulta para extraer la contraseña del usuario indicado
        $consulta = $conexion->prepare("SELECT password FROM tabla_usuarios WHERE usuario= ?");
        $consulta->execute([$user]);
        //Extraemos el resultado de la consulta
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);


        //Si resultado contiene un valor y las contraseñas hasheadas coinciden informará
        //password_verify($pass, $resultado['password']) hashea $pass, y $resultado['password'] es la que ya está hasheada en 
        // la base de datos
        if ($resultado && password_verify($pass, $resultado['password'])) {
            echo '<p style= color:green> Login successful</p>';

            //Si algun dato es incorrecto, saltará la excepción
        } else {
            throw new Exception('Datos incorrectos!');
        };

    } catch (Exception $e) {
        echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';
    }
}

?>

<!--HTML-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h3>Login</h3>
    <form action="#" method="post">
        <label for="user">Usuario:</label>
        <input type="text" name="nombre_usuario">
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña_usuario">
        <br> <br>
        <input type="submit" value="Enviar">
    </form>
    <br> <br>
    <a href="RegistrarUsers.php">Ir a "Registrar Usuarios"</a>
</body>

</html>