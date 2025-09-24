<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primera prueba php</title>
</head>
<body>
    Este es un archivo php que se encuentra en el servidor.

    <?php
include('principal.php');
include_once('otro.php');
require('prueba.inc.php');
require_once('inventado.php');
?>
</body>
</html>