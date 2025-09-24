<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>
</head>

<body>
    <?php include('cabecera.inc.php') ?>
    <?php

 echo "Fecha: " .  $_GET['fecha'] . '<br>';
    echo 'Usuario: ';
    echo $_GET['nombre'] . ' ' . $_GET['Apellidos'];
    echo '<br>Teléfono: ' . $_GET['tlf'] . '<br> Email: ' . $_GET['email'];
    echo '<br>Consulta: ' . $_GET['Consulta'];
    ?>
</body>
<?php include('footer.inc.php') ?>
</html>