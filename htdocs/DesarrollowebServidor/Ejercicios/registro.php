<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <?php include('cabecera.inc.php'); ?>

    <form action="#" method="POST">
        <?php
        $valido = [];
        $errores = [];

        /*Validación de que toda la información */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            /*Pasamos los valores a otra variable para poder manipular el dato $valido[nombre_Campo] */
            $valido['contraseña'] = $_POST['contraseña'] ?? '';
            $valido['contraseña2'] = $_POST['contraseña2'] ?? '';

            /*Validación de que las contraseñas son iguales */
            if ($valido['contraseña'] !== $valido['contraseña2']) {
                $errores['contraseña'] = "¡Las contraseñas no coinciden!";
                echo  "<p style = 'color: red'>¡Las contraseñas no coinciden!</p>";

                /*Si no coinciden se borra el contenido de los campos */
                $valido['contraseña'] = '';
                $valido['contraseña2'] = '';
            }

            /*Pasamos los valores a otra variable para poder manipular el dato $valido[nombre_Campo] */
            $valido['email'] = $_POST['email'] ?? '';

            /*Comprueba que el correo cumpla el formato con filter_Var */
            if (!filter_var($valido['email'], FILTER_VALIDATE_EMAIL)) {
                /*Si no lo cumple vacia el campo e informa */
                $errores['email'] = "¡El email no es válido!";
                echo "<p style = 'color: red'>¡El email no es válido! </p>";
                $valido['email'] = '';
            }

            /*Si el array de erores está vacío se enviará el formulario correctamente y se vaciará */
            if (empty($errores)) {
                $_POST['nombre'] = '';
                $_POST['Apellidos'] = '';
                $_POST['Username'] = '';
                $_POST['contraseña'] = '';
                $_POST['contraseña2'] = '';
                $_POST['email'] = '';
                $_POST['nacimiento'] = '';
                $_POST['genero'] = '';
                $_POST['condiciones'] = true;
                echo ' <p style="color:green;">¡Formulario enviado correctamente!</p>';
            }
        }
        ?>

        <fieldset>
            <legend>Formulario</legend>

            <!--echo isset($_POST['nombre']) ? $_POST['nombre'] : ''  Esto significa que si  el valor de nombre
    contiene algo que lo deje en el input al darle a submit, si no contiene nada lo dejará vacío con ''-->

            <label for="name">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>" required>
            <br>
            <br>
            <label for="Apellidos">Apellidos:</label>
            <input type="text" name="Apellidos" value="<?php echo isset($_POST['Apellidos']) ? $_POST['Apellidos'] : '' ?>" required>
            <br>
            <br>
            <label for="Username">Username:</label>
            <input type="text" name="Username" value="<?php echo isset($_POST['Username']) ? $_POST['Username'] : '' ?>">
            <br>
            <br>
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" id="c" required <?php echo isset($_POST['contraseña']) ? $_POST['contraseña'] : '' ?>>
            <label for="contraseña2">Confirma la contraseña:</label>
            <input type="password" name="contraseña2" id="contraseña2" value="<?php echo isset($_POST['contraseña2']) ? $_POST['contraseña2'] : ''  ?>" required>


            <br>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
            <br>
            <br>
            <label for="nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="nacimiento" id="nacimiento" value="<?php echo isset($_POST['nacimiento']) ? $_POST['nacimiento'] : '' ?>" required>
            <br>
            <br>
            <label for="genero">Género:</label>
            <select name="genero" id="genero" required>
                <option value="">Selecciona un género</option>
                <option value="mujer" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'mujer') ? 'selected' : ''; ?>>Mujer</option>
                <option value="hombre" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'hombre') ? 'selected' : ''; ?>>Hombre</option>
                <option value="otros" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'otros') ? 'selected' : ''; ?>>Otros</option>
            </select>
            <br>
            <br>
            <input type="checkbox" name="condiciones" id="condiciones" value="1" <?php echo isset($_POST['condiciones']) ? 'unchecked' : ''; ?> required>
            <label for="condiciones">Acepto las condiciones</label>
            <br>
            <br>
            <input type="checkbox" name="actualizaciones" id="actualizaciones" <?php echo isset($_POST['actualizaciones']) ? 'unchecked' : ''; ?>>
            <label for="actualizaciones">Acepto recibir actualizaciones</label>
            <br>
            <br>
            <input type="submit" value="Enviar">

        </fieldset>
    </form>
</body>
<?php include('footer.inc.php'); ?>

</html>