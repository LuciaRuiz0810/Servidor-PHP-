<?php
session_start();
$user_nombre =$_SESSION['username'];
$user_id = $_SESSION['Id_user'];
$ruta = "img/users/{$user_nombre}";
echo "<div style=text-align:center><img src='$ruta/{$user_id}Big.png' alt='imgPerfil'</div> ";
echo "<h3 style=text-align:center>Nombre de Usuario: $user_nombre</h3>";

echo "<a href='index.php'>Volver al inicio</a>";
?>