<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server</title>
</head>
<style>
    table,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    td {
        width: 40px;
        background-color: lightcyan;
    }

    h3{
        color: black;
        text-align: center;
    }
    .celda{
        background-color: lightgrey;
    }
</style>

<body>
    <?php include('cabecera.inc.php'); ?>

    <table>
        <?php
              echo '<tr>'. '<td class="celda">';
            echo  '<h3>Clave</h3>';
            echo '</td>';
            echo '<td class="celda"> ' . '<h3>Valor</h3>' . '</td>';
            echo '</tr>';
        foreach ($_SERVER as $clave => $valor) {
         
            echo '<tr>'. '<td>';
            echo  $clave;
            echo '</td>';
            echo '<td>' . $valor . '</td>';
            echo '</tr>';
        }
        ?>
    </table>

    <p>Volver a <a href="principal.php">Principal</a>
</p>

</body>

<?php include('footer.inc.php'); ?>

</html>