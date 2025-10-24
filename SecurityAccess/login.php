<?php
$pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//Si existe la cookie y el usuario aún no ha hecho el login
if (isset($_COOKIE['user']) && !isset($_POST['login'])) {
    
    //Se obtiene el nombre del usuario
    $usuario_cookie = htmlspecialchars($_COOKIE['user']);
    //Saltará el formulario donde el usuario podrá decidir si iniciar sesión con ese usuario o no
    echo "<form method='post'>
            <p>¿Deseas iniciar sesión como <strong>$usuario_cookie</strong>?</p>
            <button type='submit' name='login' value='si'>Sí</button>
            <button type='submit' name='login' value='no'>No</button>
        </form>";

    exit;  
}

//Si existe el login y la respuesta es "si", se iniciará sesión con el usuario guardado en la cookie
if (isset($_POST['login']) && $_POST['login'] === 'si') {
    echo "<p style='color:green;'>Acceso exitoso como " . htmlspecialchars($_COOKIE['user']) . "</p>";
    exit;
}

//Si la respuesta es "no" se desactivará la cookie con ese usuario
if (isset($_POST['login']) && $_POST['login'] === 'no') {
    setcookie("user", "", time() - 60, "/");  
    unset($_COOKIE['user']);
}


 //Si se envia el formulario y ambos campos contienen valores
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'], $_POST['password'])) {
    //Se obtienen los datos
    $usuario = $_POST['user'];
    $contraseña = $_POST['password'];

    //Se recupera la contraseña hasheada del usuario correspondiente
    $stmt = $pdo->prepare("SELECT password FROM tabla_usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    //Obtenemos el resultado
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //Hasheamos la contraseña introducida y se compara con la obtenida en la consulta
    if ($user && password_verify($contraseña, $user['password'])) {
        //Si existe, se inicia sesión y se establece la cookie
        echo "<p style='color:green;'>Bienvenido, $usuario</p>";
        setcookie("user", $usuario, time() + 60, "/"); 
    } else {
        //Si es incorrecto se informa
        echo "<p style='color:red;'>Datos incorrectos</p>";
    }
}

?>

<!--Formulario de inicio de sesión original-->
<form method="post">
    <h2>Iniciar Sesión</h2>
    <input name="user" placeholder="Usuario" required>
    <br><br>
    <input type="password" name="password" placeholder="Contraseña" required>
    <br><br>
    <button type="submit">Enviar</button>
</form>
<p>Ir a <a href='RegistrarUsers.php'>Registrar Usuarios</a></p>
