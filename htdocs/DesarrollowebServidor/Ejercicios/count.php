<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Count</title>
</head>

<body>
    <?php include('cabecera.inc.php');
     $total = 5;
    $resultado = 1;
    $y = 5;
    for ($x = 1; $x <= 30; $x++) {
        echo $x . " ";
    }
    echo '<br>';
    echo '5! =';

    for ($i = $total; $i >= 1; $i--) {
        $resultado = $resultado * $i;
    }
    for ($y = 5; $y >= 1; $y--) {
        if ($y != 1) {
            echo $y . ' x ';
        } else {
            echo $y . '=' . $resultado;
        }
    }

    ?>


</body>

<?php include('footer.inc.php'); ?>

</html>