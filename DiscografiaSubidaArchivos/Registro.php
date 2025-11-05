<?php
session_start();

//Conexión a la base de datos
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Añadir usuario
if (isset($_POST['enviar']) && isset($_FILES['archivo'])) {

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

        // ✅ Obtener ID del usuario insertado
        $idUsuario = $conexion->lastInsertId();

        // ✅ Crear variables de sesión para usar después
        $_SESSION['Id_user'] = $idUsuario;
        $_SESSION['username'] = $user;

    } catch (PDOException $e) {
        echo '<p style= color:red> ¡Error!: ' . $e->getMessage() . '</p>';
    }

    try {
        //Manejo de errores en la subida del archivo
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No se envió ningún archivo');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('El archivo excede el tamaño permitido');
            default:
                throw new RuntimeException('Error desconocido al subir archivo');
        }

        //Control de ataques
        if (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            throw new RuntimeException('Posible ataque: archivo no válido');
        }

        //Obtenemos el nombre del archivo
        $archivo = $_FILES['archivo']['tmp_name'];
        //Obtenemos el tipo de archivo
        $tipo = $_FILES['archivo']['type'];
        //Obtenemos las medidas
        list($ancho, $alto) = getimagesize($archivo);

        //comprobación de que el archivo es png o jpg
        if ($tipo != 'image/png' && $tipo != 'image/jpg' && $tipo != 'image/jpeg') {
            throw new RuntimeException('Error: Solo se permiten archivos PNG o JPG');
        }

        //Comprobar que cumple con el tamaño
        if ($ancho > 360 || $alto > 480) {
            throw new RuntimeException('La imagen supera el tamaño máximo de 360x480px');
        }

        //Crear la imagen jpeg o png
        if ($tipo == 'image/jpeg' || $tipo == 'image/jpg') {
            $imagenOriginal = imagecreatefromjpeg($archivo);
        } else if ($tipo == 'image/png') {
            $imagenOriginal = imagecreatefrompng($archivo);
        }

        //creación imagen grande 360 x 480
        $imagenGrande = imagecreatetruecolor(360, 480);
        imagecopyresampled($imagenGrande, $imagenOriginal, 0, 0, 0, 0, 360, 480, $ancho, $alto);

        //creación imagen pequeña 72 x 96
        $imagenPeque = imagecreatetruecolor(72, 96);
        imagecopyresampled($imagenPeque, $imagenOriginal, 0, 0, 0, 0, 72, 96, $ancho, $alto);

        //obtenemos el ID y nombre del usuario para la ruta
        $idUsuario = $_SESSION['Id_user'];
        $username = $_SESSION['username'];

        //creación ruta
        $ruta = __DIR__ . "/img/users/{$username}";
        if (!is_dir($ruta)) {
            mkdir($ruta, 0777, true);
        }

        //guardamos las imagenes en las rutas correspondientes
        $ruta_big = "$ruta/{$idUsuario}Big.png";
        $ruta_small = "$ruta/{$idUsuario}Small.png";

        //Guardamos las imágenes en la ruta incluyendo el id del usuario
        imagepng($imagenGrande, $ruta_big);
        imagepng($imagenPeque, $ruta_small);

        //guardamos las rutas en tabla_usuarios
        $consulta = $conexion->prepare('UPDATE tabla_usuarios SET url_big = ?, url_small = ? WHERE id = ?');
        $consulta->execute(["img/users/$username/{$idUsuario}Big.png", "img/users/$username/{$idUsuario}Small.png", $idUsuario]);

        //si falla se lanza una excepción
        if (!$consulta) {
            throw new PDOException('Fallo al añadirla a la base de datos!');
        }

        //Libremos la memoria 
        imagedestroy($imagenOriginal);
        imagedestroy($imagenGrande);
        imagedestroy($imagenPeque);

        //Redirigimos al login
        header('Location: login.php');
        exit;
    
    
    } catch (RuntimeException $e) {
        header('Location: registro.php?msgE=' . $e->getMessage());
        exit;
    }
}
?>

<!--Formulario Registro-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Registro</title>
</head>
<body>
<h2>Registrar nuevo usuario</h2>
<form action="" method="post" enctype="multipart/form-data">

    <label for="usuario">Nombre Usuario:</label>
    <input type="text" name="user" id="usuario" required>
    <br><br>

    <label for="contraseña">Contraseña:</label>
    <input type="password" name="pass" id="contraseña" required>
    <br><br>

    <label>Seleccionar imagen:</label>
    <input type="file" name="archivo" required>
    <br><br>

    <button type="submit" name="enviar">Registrarse</button>
</form>

<p>Ir a <a href="login.php">Login</a></p>
</body>
</html>
